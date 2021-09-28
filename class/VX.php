<?php

use Firebase\JWT\JWT;
use Google\Authenticator\GoogleAuthenticator;
use Laminas\Db\Adapter\AdapterAwareInterface;
use Laminas\Db\Adapter\AdapterAwareTrait;
use Laminas\Permissions\Acl\Acl;
use Laminas\Permissions\Acl\AclInterface;
use League\Flysystem\FileAttributes;
use League\Flysystem\StorageAttributes;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use PUXT\Context;
use R\DB\Schema;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
use VX\ACL as VXACL;
use VX\AuthLock;
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
use VX\UserGroup;

/**
 * @property User $user
 * @property int $user_id
 * @property Module $module
 */
class VX extends Context implements AdapterAwareInterface
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

    public function __construct()
    {
        $this->res = new Response;
        $this->ui = new UI($this);
        Model::$_vx = $this;
        $this->vx_root = dirname(__DIR__);
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
        $acl->allow(null, "index");
        $acl->allow(null, "login");
        $acl->allow(null, "logout");
        $acl->allow(null, "cancel-view-as");


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
                if ($a->action == "all") {
                    $acl->allow("ug-{$a->usergroup_id}", $a->module);
                } else {
                    $acl->allow("ug-{$a->usergroup_id}", $a->module, $a->action);
                }
                continue;
            }

            if (!$acl->hasResource($a->module . "/" . $a->path)) {
                $acl->addResource($a->module . "/" . $a->path, $a->module);
            }

            if ($a->value == "allow") {
                $acl->allow("ug-{$a->usergroup_id}", $a->module . "/" . $a->path);
            } elseif ($a->value == "deny") {
                $acl->deny("ug-{$a->usergroup_id}", $a->module . "/" . $a->path);
            }
        }

        if ($this->module) {
            if (!$acl->hasResource($this->module)) {
                $acl->addResource($this->module);
            }
            foreach ($this->module->getFiles() as $file) {
                if (!$acl->hasResource($file)) {
                    $acl->addResource($file, $this->module);
                }
            }
        }


        $this->acl = $acl;
        return $this->acl;
    }

    public function init(Context $context)
    {


        foreach ($context as $k => $v) {
            $this->$k = $v;
        }

        $config = $this->config["VX"];
        if ($config["table"]) {
            foreach ($config["table"] as $k => $v) {
                $r_class = new ReflectionClass($k);
                $r_class->setStaticPropertyValue("_table", $v);
            }
        }

        $this->_files = [];
        foreach ($this->req->getUploadedFiles() as $name => $file) {

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

        foreach (Translate::Query(["module" => "", "language" => $locale]) as $t) {
            $a[$t->name] = $t->value;
        }


        foreach (Translate::Query(["module" => $this->module->name, "language" => $locale]) as $t) {
            $a[$t->name] = $t->value;
        }
        $translator->addResource("array", $a, $locale);

        $this->translator = $translator;
        $this->ui->setTranslator($this->translator);
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

        foreach (Translate::Query(["module" => "", "language" => $locale]) as $t) {
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
        return $twig;
    }

    public function getMailer()
    {
        return new Mailer();
    }

    public function getModuleByPath(string $path)
    {
        $ps = explode("/", $path);
        $ps = array_values(array_filter($ps, "strlen"));
        return $this->getModule($ps[0]);
    }


    public function login(string $username, string $password, ?string $code = null): ?User
    {

        if (AuthLock::IsLockedIP($_SERVER["REMOTE_ADDR"])) {
            throw new Exception("IP locked 180 seconds", 403);
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $ul = UserLog::Create();
        $ul->login_dt = date("Y-m-d H:i:s");
        $ul->ip = $ip;
        $ul->user_agent = $_SERVER["HTTP_USER_AGENT"];

        try {
            $user = User::Login($username, $password);

            if ($user->need2Step($_SERVER["REMOTE_ADDR"])) {
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

    public function getModule(string $name)
    {

        if (file_exists($this->root . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $name)) {
            $config = [];
            if (file_exists($setting = $this->root . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . "setting.yml")) {
                $config = Yaml::parseFile($setting);
            }

            return new Module($name, $config);
        }

        if (file_exists(dirname(__DIR__) . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $name)) {
            $config = [];
            if (file_exists($setting = dirname(__DIR__) . "/pages/$name/setting.yml")) {
                $config = Yaml::parseFile($setting);
            }

            return new Module($name, $config);
        }
    }

    /**
     * @return Module[]
     */
    public function getModules()
    {

        $modules = [];
        foreach (glob($this->root . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "*", GLOB_ONLYDIR) as $m) {
            $name = basename($m);

            if (!$this->acl->hasResource($name)) {
                $this->acl->addResource($name);
            }

            $module = new Module($name);
            $module->loadConfigFile($m . "/setting.yml");
            $module->setTranslator($this->translator);
            $module->setAcl($this->acl);

            foreach ($module->getFiles() as $file) {
                if (!$this->acl->hasResource($file)) {
                    $this->acl->addResource($file, $module);
                }
            }

            $modules[$name] = $module;
        }

        foreach (glob(dirname(__DIR__) . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "*", GLOB_ONLYDIR) as $m) {
            $name = basename($m);

            if (!$this->acl->hasResource($name)) {
                $this->acl->addResource($name);
            }

            if (!$module = $modules[$name]) {
                $module = new Module($name);
                $module->setTranslator($this->translator);
                $module->setAcl($this->acl);
            }

            $module->loadConfigFile($m . "/setting.yml");

            foreach ($module->getFiles() as $file) {
                if (!$this->acl->hasResource($file)) {
                    $this->acl->addResource($file, $module);
                }
            }


            $modules[$name] = $module;
        }


        return array_values($modules);
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
}
