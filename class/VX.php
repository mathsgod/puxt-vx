<?php

use Firebase\JWT\JWT;
use Google\Authenticator\GoogleAuthenticator;
use Laminas\Db\Adapter\AdapterAwareInterface;
use Laminas\Db\Adapter\AdapterAwareTrait;
use Laminas\Db\Sql\Where;
use Laminas\Permissions\Acl\Acl;
use Laminas\Permissions\Acl\AclInterface;
use League\Flysystem\FileAttributes;
use League\Flysystem\StorageAttributes;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PUXT\App;
use PUXT\Context;
use R\DB\Schema;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
use VX\ACL as VXACL;
use VX\AuthLock;
use VX\Config;
use VX\EventLog;
use VX\IModel;
use VX\Mailer;
use VX\Model;
use VX\Module;
use VX\Response;
use VX\Translate;
use VX\User;
use VX\UserLog;
use VX\UI;
use Webauthn\PublicKeyCredentialUserEntity;
use Webauthn\PublicKeyCredentialRpEntity;
use VX\PublicKeyCredentialSourceRepository;
use VX\SystemValue;
use VX\TwigI18n;
use VX\UserGroup;

/**
 * @property User $user
 * @property int $user_id
 * @property Module $module
 */
class VX extends Context implements AdapterAwareInterface, MiddlewareInterface
{

    use AdapterAwareTrait;
    public $user;
    public $user_id;
    public $module;
    public $logined = false;
    public $res;
    /**
     * @var \Laminas\Permissions\Acl\Acl
     */
    private $acl;
    public $ui;
    public $config = [];
    public Translator $translator;
    public $vx_root;
    public $locale;
    public $db;

    private $modules = [];
    private $puxt;

    public $base_path;

    public function __construct(App $puxt)
    {

        $this->puxt = $puxt;
        $this->base_path = $puxt->base_path;
        $this->root = $puxt->root;
        $this->config = $puxt->config;
        $this->res = new Response;
        $this->ui = new UI($this);
        Model::$_vx = $this;
        $this->vx_root = dirname(__DIR__);

        $this->loadModules();



        $db_config = $puxt->config["database"];
        $schema = new Schema($db_config["database"], $db_config["hostname"], $db_config["username"], $db_config["password"]);


        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
        $schema->setDefaultValidator($validator);

        $this->setDbAdapter($schema->getDbAdatpter());
        $this->db = $schema;
        Model::SetSchema($schema);
    }

    private function loadModules()
    {
        //system module
        $modules = [];
        foreach (glob($this->vx_root . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "*", GLOB_ONLYDIR) as $m) {
            $modules[] = basename($m);
        }

        //user module
        foreach (glob(getcwd() . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "*", GLOB_ONLYDIR) as $m) {
            $modules[] = basename($m);
        }

        $modules = array_values(array_unique($modules));

        foreach ($modules as $module) {
            $this->modules[] = new Module($this, $module);
        }
    }

    function getUserIdByToken(string $token)
    {
        $token = JWT::decode($token, $this->config["VX"]["jwt"]["secret"], ["HS256"]);
        return $token->user_id;
    }

    function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->request = $request;


        $this->processConfig();
        $this->processAuthorization($request);
        $this->processTranslator();

        $this->_get = $_GET;
        $this->_post = $request->getParsedBody();

        $request = $request->withAttribute("context", $this)
            ->withAttribute("user", $this->user);

        $response = $handler->handle($request);

        if ($_SERVER["HTTP_ORIGIN"]) {
            $response = $response->withHeader("Access-Control-Allow-Origin", $_SERVER["HTTP_ORIGIN"]);
        }
        $response = $response
            ->withHeader("Access-Control-Allow-Credentials", "true")
            ->withHeader("Access-Control-Allow-Headers", "Content-Type, Authorization, vx-view-as, rest-jwt")
            ->withHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS, PUT, PATCH, HEAD, DELETE")
            ->withHeader("Access-Control-Expose-Headers", "location, Content-Location");

        return $response;
    }

    private function processTranslator()
    {
        $locale = $this->user->language ?? "en";
        $this->locale = $locale;
        //translator
        $translator = new Translator($locale);
        $translator->setFallbackLocales(["en"]);

        if (file_exists($this->vx_root . "/messages.$locale.yml")) {
            $translator->addLoader("yaml", new YamlFileLoader);
            $translator->addResource('yaml', $this->vx_root . "/messages.$locale.yml", $locale);
        }

        //en
        if (file_exists($this->vx_root . "/messages.en.yml")) {
            $translator->addLoader("yaml", new YamlFileLoader);
            $translator->addResource('yaml', $this->vx_root . "/messages.en.yml", "en");
        }


        //load from db
        $translator->addLoader("array", new ArrayLoader);
        $a = [];

        foreach (Translate::Query(["language" => $locale])->where(function (Where $w) {
            $w->expression("module is null or module=''", []);
        }) as $t) {
            $a[$t->name] = $t->value;
        }

        foreach (Translate::Query(["module" => $this->module->name, "language" => $locale]) as $t) {
            $a[$t->name] = $t->value;
        }
        $translator->addResource("array", $a, $locale);

        $this->translator = $translator;
        $this->ui->setTranslator($this->translator);
    }

    private function processConfig()
    {
        $parser = new Parser;
        foreach ($parser->parseFile($this->vx_root . "/default.config.yml") as $k => $v) {
            $this->config["VX"][$k] = $v;
        }

        foreach (Config::Query() as $config) {
            $this->config["VX"][$config->name] = $config->value;
        }
    }

    private function processAuthorization(ServerRequestInterface $request)
    {
        //authorization

        $this->user_id = 2;

        $query = $request->getQueryParams();
        if ($query["_token"]) {
            $token = $query["_token"];
        } else {
            $authorization = $request->getHeaderLine("Authorization");
            if ($authorization) {
                $authorization = explode(" ", $authorization);
                if (count($authorization) == 2) {
                    $token = $authorization[1];
                }
            }
        }

        if ($token) {
            if ($user_id = $this->getUserIdByToken($token)) {
                $this->user_id = $user_id;
                $this->logined = true;
            }
        }

        $this->user = User::Get($this->user_id);

        if ($view_as = $request->getHeaderLine("vx-view-as")) {
            if ($this->user->isAdmin()) {
                $view_as = intval($view_as);
                if ($user = User::Get($view_as)) {
                    $this->view_as = $view_as;
                    $this->user_id = $view_as;
                    $this->user = $user;
                }
            }
        }
    }

    public function getModule(string $name): ?Module
    {
        foreach ($this->modules as $module) {
            if ($module->name == $name) {
                return $module;
            }
        }
        return null;
    }

    function getSystemValue(string $name)
    {
        $sv = SystemValue::Query(["name" => $name, "language" => $this->user->language])->first();
        if ($sv) {
            return $sv->getValues();
        }
        return [];
    }

    public function getDB(): Schema
    {
        return $this->db;
    }

    public function getFileUploadMaxSize()
    {
        $parse_size = function ($size) {
            $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
            $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
            if ($unit) {
                // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
                return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
            } else {
                return round($size);
            }
        };
        $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $post_max_size = $parse_size(ini_get('post_max_size'));
            if ($post_max_size > 0) {
                $max_size = $post_max_size;
            }

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = $parse_size(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }
        return $max_size;
    }

    public function getWebAuthnServer()
    {
        $name = $_SERVER["SERVER_NAME"];
        $id = $_SERVER["SERVER_NAME"];
        if ($id == "0.0.0.0") {
            $id = "localhost";
            $name = "localhost";
        }

        $user = $this->user;
        $userEntity = new PublicKeyCredentialUserEntity($user->username, $user->user_id, $user->first_name . " " . $user->last_name);

        $rp = new PublicKeyCredentialRpEntity($name, $id);
        $source = new PublicKeyCredentialSourceRepository();
        $server = new Webauthn\Server($rp, $source);
        return $server;
    }

    function generateToken(User $user, array $data)
    {
        return JWT::encode([
            "iat" => time(),
            "exp" => time() + 3600,
            "user_id" => $user->user_id,
            "data" => $data
        ], $this->config["VX"]["jwt"]["secret"]);
    }

    function jwtDecode(string $jwt)
    {
        $data =  JWT::decode($jwt, $this->config["VX"]["jwt"]["secret"], ["HS256"]);
        return json_decode(json_encode($data), true);
    }

    public function generateAccessToken(User $user)
    {
        return JWT::encode([
            "type" => "access_token",
            "iat" => time(),
            "exp" => time() + 3600,
            "user_id" => $user->user_id
        ], $this->config["VX"]["jwt"]["secret"]);
    }

    public function generateRefreshToken(User $user)
    {
        return JWT::encode([
            "type" => "refresh_token",
            "iat" => time(),
            "exp" => time() + 3600 * 24, //1 day
            "user_id" => $user->user_id
        ], $this->config["VX"]["jwt"]["secret"]);
    }

    public function getFileManager()
    {
        $root = $this->root . DIRECTORY_SEPARATOR . "uploads";
        if ($this->config["VX"]["file_manager"]["root"]) {
            $root = $this->config["VX"]["file_manager"]["root"];
        }

        $visibility = [
            'file' => [
                'public' => 0640,
                'private' => 0640,
            ],
            'dir' => [
                'public' => 0777,
                'private' => 0777,
            ],
        ];

        if ($this->config["VX"]["file_manager"]["visibility"]) {
            $visibility = $this->config["VX"]["file_manager"]["visibility"];
        }
        $visibilityConverter = PortableVisibilityConverter::fromArray($visibility);

        $adapter = new League\Flysystem\Local\LocalFilesystemAdapter($root, $visibilityConverter);
        $fs = new League\Flysystem\Filesystem($adapter);
        return $fs;
    }

    public function getAcl(): AclInterface
    {
        if ($this->acl) return $this->acl;

        //acl
        $acl = new Acl;

        $ugs = [];
        foreach (UserGroup::Query() as $usergroup) {
            $acl->addRole($usergroup);

            $ugs[$usergroup->name] = $usergroup;
        }

        foreach (User::Query() as $user) {
            $acl->addRole($user, $user->UserGroup());
        }

        $acl->allow(UserGroup::GetByNameOrCode("Administrators"));

        $acl->addResource("index");
        $acl->addResource("login");
        $acl->addResource("logout");
        $acl->addResource("cancel-view-as");
        $acl->addResource("error");
        $acl->allow(null, "index");
        $acl->allow(null, "login");
        $acl->allow(null, "logout");
        $acl->allow(null, "cancel-view-as");
        $acl->allow(null, "error");


        $adapter = new League\Flysystem\Local\LocalFilesystemAdapter($this->root . DIRECTORY_SEPARATOR . "/class");
        $fs = new League\Flysystem\Filesystem($adapter);
        $php = $fs->listContents("/")->filter(function (StorageAttributes $attr) {
            return $attr->isFile();
        })->map(function (FileAttributes  $attr) {
            return pathinfo($attr->path(), PATHINFO_FILENAME);
        });
        foreach ($php as $r) {
            $acl->addResource($r);
        }

        $acl_data = Yaml::parseFile(dirname(__DIR__) . DIRECTORY_SEPARATOR . "acl.yml");
        foreach ($acl_data["path"] as $module => $paths) {
            if (!$acl->hasResource($module)) {
                $acl->addResource($module);
            }

            foreach ($paths as $path => $roles) {
                $acl->addResource($module . "/" . $path, $module);

                foreach ($roles as $role) {

                    $acl->allow($ugs[$role], $module . "/" . $path);
                }
            }
        }


        foreach (VXACL::Query() as $a) {
            if (!$a->module) continue;

            if (!$acl->hasResource($a->module)) {
                $acl->addResource($a->module);
            }

            if ($a->action) {
                if ($a->usergroup_id) {
                    if ($a->action == "all") {
                        $acl->allow("ug-{$a->usergroup_id}", $a->module);
                    } else {
                        $acl->allow("ug-{$a->usergroup_id}", $a->module, $a->action);
                    }
                }

                if ($a->user_id) {
                    if ($a->action == "all") {
                        $acl->allow("u-{$a->user_id}", $a->module);
                    } else {
                        $acl->allow("u-{$a->user_id}", $a->module, $a->action);
                    }
                }
                continue;
            }

            if (!$acl->hasResource($a->module . "/" . $a->path)) {
                $acl->addResource($a->module . "/" . $a->path, $a->module);
            }

            if ($a->usergroup_id) {
                if ($a->value == "allow") {
                    $acl->allow("ug-{$a->usergroup_id}", $a->module . "/" . $a->path);
                } elseif ($a->value == "deny") {
                    $acl->deny("ug-{$a->usergroup_id}", $a->module . "/" . $a->path);
                }
            }

            if ($a->user_id) {
                if ($a->value == "allow") {
                    $acl->allow("u-{$a->user_id}", $a->module . "/" . $a->path);
                } elseif ($a->value == "deny") {
                    $acl->deny("u-{$a->user_id}", $a->module . "/" . $a->path);
                }
            }
        }


        foreach ($this->getModules() as $module) {
            if (!$acl->hasResource($module)) {
                $acl->addResource($module);
            }

            foreach ($module->getFiles() as $file) {
                if (!$acl->hasResource($file)) {
                    $acl->addResource($file, $module);
                }
            }
        }


        $this->acl = $acl;
        return $this->acl;
    }

    function init(Context $context)
    {
        return;
        foreach ($context as $k => $v) {
            $this->$k = $v;
        }

        //set default config
        $this->config["VX"]["authentication_lock"] = true;
        $this->config["VX"]["authentication_lock_time"] = 180;



        $config = $this->config["VX"];
        if ($config["table"]) {
            foreach ($config["table"] as $k => $v) {
                $r_class = new ReflectionClass($k);
                $r_class->setStaticPropertyValue("_table", $v);
            }
        }

        $this->_files = [];
        foreach ($this->request->getUploadedFiles() as $name => $file) {

            if (is_array($file)) {
                $this->_files[$name] = $file;
                continue;
            }

            if ($file->getClientMediaType() == "application/json" && $name == "vx") {
                $this->_post = json_decode($file->getStream()->getContents(), true);
                continue;
            }
            $this->_files[$name] = $file;
        }



        //        $auth = $context->req->getHeader("Authorization");

        $token = $this->req->getHeader("Authorization")[0];
        if ($token) {
            $jwt = explode("Bearer ", $token)[1];
        }

        if ($this->req->getQueryParams()["_token"]) {
            $jwt = $this->req->getQueryParams()["_token"];
        }

        $this->user_id = 2;
        if ($jwt) {
            try {
                $data = (array)JWT::decode($jwt, $this->config["VX"]["jwt"]["secret"], ["HS256"]);
                if ($user = User::Load($data["user_id"])) {
                    $this->user = $user;
                    $this->user_id = $user->user_id;
                    $this->logined = true;
                } else {
                    throw new Exception("user not found");
                }


                if ($view_as = $this->req->getHeaderLine("vx-view-as")) {
                    if ($this->user->isAdmin()) {
                        if ($user = User::Load($view_as)) {
                            $this->view_as = $view_as;
                            $this->user_id = $view_as;
                            $this->user = $user;
                        }
                    }
                }
            } catch (Exception $e) {
                $this->user = User::Load($this->user_id);
            }
        } else {
            $this->user = User::Load($this->user_id);
        }

        $path = $context->route->path;
        $p = explode("/", $path)[0];
        $this->module = $this->getModule($p);
    }

    public function getModuleTranslate()
    {
        $a = [];
        foreach (Translate::Query(["language" => $this->locale]) as $tran) {
            if (!$tran->module) continue;
            $a[$tran->module][$tran->name] = $tran->value;
        }

        return $a;
    }

    public function getGlobalTranslator()
    {
        $locale = $this->locale;
        $translator = new Translator($this->locale);
        $translator->setFallbackLocales(["en"]);

        if (file_exists($this->vx_root . "/messages.$locale.yml")) {
            $translator->addLoader("yaml", new YamlFileLoader);
            $translator->addResource('yaml', $this->vx_root . "/messages.$locale.yml", $locale);
        }


        if (file_exists($this->vx_root . "/messages.en.yml")) {
            $translator->addLoader("yaml", new YamlFileLoader);
            $translator->addResource('yaml', $this->vx_root . "/messages.en.yml", "en");
        }

        //load from db
        $translator->addLoader("array", new ArrayLoader);

        $a = [];

        foreach (Translate::Query(["language" => $locale])->where(function (Where $w) {
            $w->expression("module is null or module=''", []);
        }) as $t) {
            $a[$t->name] = $t->value;
        }
        $translator->addResource("array", $a, $locale);


        return $translator;
    }

    public function getTranslator()
    {
        return $this->translator;
    }

    public function findWebauthnUserByUsername(string $username): ?PublicKeyCredentialUserEntity
    {
        $user = User::Query(["username" => $username])->first();

        if (!$user) return null;

        return new PublicKeyCredentialUserEntity($user->username, $user->user_id, $user->first_name . " " . $user->last_name);
    }

    public function resetPassword(string $password, string $token)
    {
        $payload = (array)JWT::decode($token, $this->config["VX"]["jwt"]["secret"], ["HS256"]);
        $user = User::Load($payload["user_id"]);
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->save();
    }

    public function forgotPassword(string $username, string $email)
    {
        $user = User::Query(["username" => $username, "email" => $email, "status" => 0])->first();
        if (!$user) return;

        $token = JWT::encode([
            "type" => "access_token",
            "iat" => time(),
            "exp" => time() + 3600,
            "user_id" => $user->user_id
        ], $this->config["VX"]["jwt"]["secret"]);

        $reset_link = $this->config["VX"]["vx_url"] . "/reset-password?token=" . $token;

        $html = $this->getTwig()->load("templates/reset-password.twig")->render([
            "ip" => $_SERVER["REMOTE_ADDR"],
            "user" => $user,

            "company" => [
                "name" => $this->config["VX"]["company"],
                "logo" => $this->config["VX"]["company_logo"],
                "url" => $this->config["VX"]["company_url"]
            ],
            "reset_link" => $reset_link
        ]);

        $mailer = $this->getMailer();
        $mailer->setFrom("no-reply@" . $_SERVER["SERVER_NAME"]);
        $mailer->addAddress($user->email, (string)$user);
        $mailer->msgHTML($html);
        $mailer->send();
    }

    public function getTwig(LoaderInterface $loader = null)
    {
        if (!$loader) {
            $loader = new FilesystemLoader([$this->root, $this->vx_root]);
        }
        $twig = new Environment($loader);


        $i18n = new TwigI18n;
        $i18n->setTranslator($this->translator);
        $twig->addExtension($i18n);

        return $twig;
    }

    public function getMailer()
    {
        $mailer = new Mailer();
        if ($mail_from = $this->config["VX"]["mail_from"]) {
            $mailer->setFrom($mail_from);
        }
        return $mailer;
    }

    public function getModuleByPath(string $path)
    {
        $ps = explode("/", $path);
        $ps = array_values(array_filter($ps, "strlen"));
        return $this->getModule($ps[0]);
    }

    function isNeed2Step()
    {
        if (!$this->config["VX"]["two_step_verification"]) return false;
        //check white list

        $whitelist = $this->config["VX"]["two_step_verification_whitelist"];

        $client_ip = $_SERVER["REMOTE_ADDR"];


        if ($whitelist) {
            $whitelist = explode(",", $whitelist);
            $whitelist = array_map("trim", $whitelist);
            $whitelist = array_map("strtolower", $whitelist);
            $whitelist = array_filter($whitelist);

            foreach ($whitelist as $ip) {
                $cx = explode("/", $ip);
                if (sizeof($cx) == 1) {
                    $cx[1] = "255.255.255.255";
                }
                $res = ip2long($cx[0]) & ip2long($cx[1]);
                $res2 = ip2long($client_ip) & ip2long($cx[1]);
                if ($res == $res2) {
                    return false;
                }
            }
        }
        return true;
    }

    // login with username, password and code, throw exception if failed
    function login(string $username, string $password, ?string $code = null): User
    {
        $ip = $_SERVER['REMOTE_ADDR'];


        if ($this->config["VX"]["authentication_lock"]) {
            $time = $this->config["VX"]["authentication_lock_time"];
            if (AuthLock::IsLockedIP($ip, $time)) {
                throw new Exception("IP locked $time seconds", 403);
            }
        }

        $ul = UserLog::Create();
        $ul->login_dt = date("Y-m-d H:i:s");
        $ul->ip = $ip;
        $ul->user_agent = $_SERVER["HTTP_USER_AGENT"];

        try {
            $user = User::Login($username, $password);

            if ($this->isNeed2Step()) {
                if ($user->need2Step($ip)) {
                    if (!$code) {
                        throw new Exception("code required", 400);
                    }
                    if ($user->secret) {
                    }
                    $g = new GoogleAuthenticator();
                    if (!$g->checkCode($user->secret, $code)) {
                        throw new Exception("code incorrect");
                    }
                }
            }


            $ul->user_id = $user->user_id;
            $ul->result = "SUCCESS";
            $ul->save();
            AuthLock::ClearLockedIP($ip);
        } catch (Exception $e) {

            AuthLock::LockIP($ip);

            $user = User::Query(["username" => $username])->first();

            if ($user) {
                $ul->user_id = $user->user_id;
                $ul->result = "FAIL";
                $ul->save();
            }
            throw $e;
        }
        return $user;
    }

    public function logout()
    {
        $this->user_id = 2;
        //get last logout
        $o = UserLog::Query([
            "user_id" => $this->user_id
        ])->order("userlog_id desc")->first();

        if ($o) {
            $o->logout_dt = date("Y-m-d H:i:s");
            $o->save();
        }
    }

    public function object(): ?IModel
    {
        if ($this->module) {
            $class = $this->module->class;

            if (class_exists($class, true)) {
                return new $class($this->object_id);
            }
        }

        return null;
    }

    /**
     * @return Module[]
     */
    public function getModules()
    {
        return $this->modules;
    }

    public function postForm()
    {
        $body = $this->_post;
        if ($obj = $this->object()) {
            $obj->bind($body);
            $obj->save();
        }
        return $obj;
    }

    public function trigger(string $name, $obj)
    {
        if ($name == "before_insert") {
            if (property_exists($obj, "created_by")) {
                $obj->created_by = $this->user_id;
            }
            return;
        }

        if ($name == "after_insert") {
            EventLog::LogInsert($obj, $this->user);
        }

        if ($name == "before_update") {
            if (property_exists($obj, "updated_by")) {
                $obj->created_by = $this->user_id;
            }

            EventLog::LogUpdate($obj, $this->user);
        }

        if ($name == "after_update") {
        }

        if ($name == "before_delete") {
            EventLog::LogDelete($obj, $this->user);
        }
    }

    function getRequestHandler(string $file)
    {
        return new \PUXT\RequestHandler($file);
    }
}
