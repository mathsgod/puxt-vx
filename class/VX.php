<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Storage\NonPersistent;
use Laminas\Config\Config;
use Laminas\Db\Adapter\AdapterAwareInterface;
use Laminas\Db\Adapter\AdapterAwareTrait;
use Laminas\Db\Sql\Where;
use Laminas\Di\InjectorInterface;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\Stream;
use Laminas\ServiceManager\ServiceManager;
use League\Event\EventDispatcherAware;
use League\Event\EventDispatcherAwareBehavior;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use League\Glide\Responses\PsrResponseFactory;
use League\Route\Http\Exception\NotFoundException;
use League\Route\RouteGroup;
use League\Route\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use R\DB\Schema;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
use VX\Authentication;
use VX\Security\UserRepositoryInterface;
use VX\Security\AuthenticationInterface;
use VX\Security\AuthenticationMiddleware;
use VX\Security\UserInterface;
use VX\AuthLock;
use VX\DefaultUserFactory;
use VX\JWTBlacklist;
use VX\ListenserSubscriber;
use VX\Mailer;
use VX\Model;
use VX\Module;
use VX\Permission;
use VX\Translate;
use VX\User;
use VX\UserLog;
use Webauthn\PublicKeyCredentialUserEntity;
use Webauthn\PublicKeyCredentialRpEntity;
use VX\PublicKeyCredentialSourceRepository;
use VX\RoleRepository;
use VX\Security\AuthenticationAdapter;
use VX\Security\RoleRepositoryInterface;
use VX\Security\Security;
use VX\SystemValue;
use VX\UserRepository;

/**
 * @property int $user_id
 * @property Module $module
 */
class VX implements AdapterAwareInterface, MiddlewareInterface, LoggerAwareInterface, EventDispatcherAware
{

    use EventDispatcherAwareBehavior;
    use LoggerAwareTrait;
    use AdapterAwareTrait;

    public UserInterface $user;

    public $user_id;
    public $module;
    public $logined = false;

    public $config;
    public Translator $translator;
    public $vx_root;
    public $locale;
    public $db;

    /**
     * @var Module[]
     */
    private $modules = [];
    private $puxt;

    public $base_path;
    public $root;


    public $_get = [];
    public $_post = [];

    /**
     * @var array<UploadedFileInterface>
     */
    public $_files = [];


    private $security;

    /**
     * @var UserRepositoryInterface
     */
    protected $user_repository;

    /**
     * @var AuthenticationService
     */
    protected $auth;

    protected $service;

    /**
     * @var InjectorInterface
     */
    protected $injector;

    public $view_as;
    public $object_id;

    public $roles;

    public $languages = [];

    public function __construct(ServiceManager $service, Config $config)
    {
        $this->service = $service;
        $this->config = $config;

        if (!$this->config->get("VX")) {
            $this->config->VX = [];
        }

        $this->vx_root = dirname(__DIR__);
        $this->root =  $service->get(PUXT\App::class)->root;
        $this->base_path = rtrim($_ENV["VX_BASE_PATH"] ?? "/api", "/");


        //load translator
        $this->translator = new Translator("en");
        $this->translator->setFallbackLocales(["en"]);

        if (file_exists($file = $this->vx_root . "/messages.en.yml")) {
            $this->translator->addLoader("yaml", new YamlFileLoader);
            $this->translator->addResource('yaml', $file, "en");
        }
        $this->service->setService(TranslatorInterface::class, $this->translator);

        //auth
        $this->auth = new AuthenticationService(new NonPersistent());


        $this->injector = $service->get(InjectorInterface::class);

        if (!$this->service->has(AuthenticationInterface::class)) {
            $this->service->setService(AuthenticationInterface::class, new Authentication);
        }

        $this->service->setFactory(AdapterInterface::class, function (ContainerInterface $container) {
            $injector = $container->get(InjectorInterface::class);
            return $injector->create(AuthenticationAdapter::class);
            //return new AuthenticationAdapter($container->get(ServerRequestInterface::class));
        });

        $this->service->setService(UserRepositoryInterface::class, new UserRepository());
        $this->service->setService(VX::class, $this);

        //load db
        $this->loadDB();

        //role
        $this->roles = new RoleRepository;
        $this->service->setService(RoleRepositoryInterface::class, $this->roles);

        $this->service->setService(Security::class, $this->getSecurity());
        $this->loadModules();

        $this->loadConfig();
        $this->loadLanguage();

        Model::$_vx = $this;

        if (!$this->service->has(UserInterface::class)) {
            $this->service->setFactory(UserInterface::class, DefaultUserFactory::class);
        }

        $this->user = $this->service->get(UserInterface::class);

        //get default user
        $this->service->has(UserInterface::class) && $this->user = $this->service->get(UserInterface::class);
    }

    function getCurrentUser(): UserInterface
    {
        return $this->user;
    }

    public function getRouter()
    {
        $vx = $this;

        $router = new Router();
        $router->setStrategy(new \VX\Route\Strategy\ApplicationStrategy($this));


        /** @var AuthenticationMiddleware $middleware */
        $middleware = $this->injector->create(AuthenticationMiddleware::class);
        $router->middleware($middleware);


        $router->addPatternMatcher("any", ".+");

        $modules = $this->getModules();
        $router->group($this->base_path, function (RouteGroup $route) use ($modules) {
            foreach ($modules as $module) {
                $module->setupRoute($route);
            }
        });


        $router->map("GET", $vx->base_path . "/drive/{id:number}/{file:any}", function (ServerRequestInterface $serverRequest, array $args) use ($vx) {

            //B5 Broken Access Control 
            if (!$vx->logined) {
                return new EmptyResponse(401);
            }


            $fm = $vx->getFileSystem();
            $file = $args["file"];
            $file = urldecode($file);

            if ($fm->fileExists($file)) {
                $response = (new ResponseFactory())->createResponse();

                $response = $response->withHeader("Content-Type", $fm->mimeType($file));
                $response = $response->withBody(new Stream($fm->readStream($file)));
                return $response;
            }
            throw new NotFoundException();
        });

        //file-upload
        $router->map("POST", $vx->base_path . "/file-upload", function (ServerRequestInterface $request) use ($vx) {

            //B5 Broken Access Control 
            if (!$vx->logined) {
                return new EmptyResponse(401);
            }

            $fm = $vx->getFileSystem();
            $files = $request->getUploadedFiles();
            $file = $files["file"];
            //generate uuid
            $uuid = Uuid::uuid4()->toString();
            $fm->write("cache/" . $uuid, $file->getStream()->getContents());
            return new JsonResponse(["uuid" => "cache/$uuid"]);
        });

        $router->map("GET", $vx->base_path . "/photo/{id:number}/{file:any}", function (ServerRequestInterface $request, array $args) use ($vx) {

            //B5 Broken Access Control 
            if (!$vx->logined) {
                return new EmptyResponse(401);
            }

            $glide = League\Glide\ServerFactory::create([

                "source" => $vx->getFileSystem(),
                "cache" => dirname($vx->root) . DIRECTORY_SEPARATOR . "cache",
                "response" => new PsrResponseFactory(new Response(), function ($stream) {
                    return new Stream($stream);
                }),
            ]);

            return  $glide->getImageResponse($args["file"], $request->getQueryParams());
        });


        $router->map("GET",  $vx->base_path, function (ServerRequestInterface $request) use ($vx) {
            return  $vx->getRequestHandler($vx->vx_root . "/pages/index")->handle($request);
        });

        $router->map("GET",  $vx->base_path . "/", function (ServerRequestInterface $request) use ($vx) {
            return  $vx->getRequestHandler($vx->vx_root . "/pages/index")->handle($request);
        });

        $router->map("POST",  $vx->base_path, function (ServerRequestInterface $request) use ($vx) {
            return $vx->getRequestHandler($vx->vx_root . "/pages/index")->handle(($request));
        });

        $router->map("GET", $vx->base_path . "/cancel-view-as", function (ServerRequestInterface $request) use ($vx) {
            return $vx->getRequestHandler($vx->vx_root . "/pages/cancel-view-as")->handle($request);
        });

        $router->map("GET",  $vx->base_path . "/error", function (ServerRequestInterface $request) use ($vx) {
            return new EmptyResponse(404);
        });

        return $router;
    }


    function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getMethod() == "OPTIONS") {
            return new EmptyResponse(200);
        }
        $request = $request->withAttribute(VX::class, $this);
        $request = $request->withAttribute(Security::class, $this->getSecurity());
        $request = $request->withAttribute(\Twig\Environment::class, $this->getTwig());

        $logger = $request->getAttribute(LoggerInterface::class);
        if ($logger instanceof LoggerInterface) {
            $logger->info("Request: " . $request->getUri()->getPath());
        }

        $this->_get = $_GET;
        $this->_post = $_POST;
        if (strpos($request->getHeaderLine("Content-Type"), "application/json") !== false) {

            $body = $request->getBody()->getContents();
            $this->_post = json_decode($body, true);
            $request = $request->withParsedBody($this->_post);
        }
        $this->_files = $request->getUploadedFiles();

        $router = $this->getRouter();

        //get the current module
        $path = $request->getUri()->getPath();
        //remove the base path
        $path = substr($path, strlen($this->base_path));
        $path = explode("/", $path);
        $module = $path[0];
        $this->module = $this->getModule($module);

        if (is_numeric($path[1])) {
            $this->object_id = $path[1];
        }


        $router->middleware(new class implements MiddlewareInterface
        {
            function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {

                $vx = $request->getAttribute(VX::class);

                $user = $request->getAttribute(UserInterface::class);
                if ($user) {
                    $vx->user = $user;
                    $vx->logined = true;
                    foreach ($user->getRoles() as $role) {
                        if ($role === "Guests") {
                            $vx->logined = false;
                            break;
                        }
                    }
                }


                //translate
                $vx->processTranslator($user->language ?? "en");


                return $handler->handle($request);
            }
        });


        $this->service->setService(ServerRequestInterface::class, $request);

        try {
            $response = $router->dispatch($request);
        } catch (Throwable $e) {
            if ($_ENV["VX_DEBUG"]) {
                $response = new HtmlResponse($e->getMessage() . "\n" . $e->getFile() . "\n" . $e->getLine(), 500);
            } else {
                $response = new HtmlResponse("Change the debug mode (VX_DEBUG) to true to see the error message", 500);
            }
        }

        if ($_SERVER["HTTP_ORIGIN"]) {
            $response = $response->withHeader("Access-Control-Allow-Origin", $_SERVER["HTTP_ORIGIN"]);
        }

        /*    $response = $response
            ->withHeader("Access-Control-Allow-Credentials", "true")
            ->withHeader("Access-Control-Allow-Headers", "Content-Type, Authorization")
            ->withHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS, PUT, PATCH, HEAD, DELETE")
            ->withHeader("Access-Control-Expose-Headers", "location, Content-Location"); */

        return $response;
    }


    public function isGranted(string $permission, $assertion = null): bool
    {
        return $this->getSecurity()->isGranted($this->user, $permission, $assertion);
    }

    public function getPresetPermissions(): array
    {
        $acl = Yaml::parseFile(dirname(__DIR__) . DIRECTORY_SEPARATOR . "acl.yml");
        $permissions = [];
        foreach ($acl["path"] as $p => $groups) {
            foreach ($groups as $group) {
                $permissions[$group][] = $p;
            }
        }

        foreach ($this->roles->findAll() as $role) {
            if (!isset($permissions[$role->getName()])) {
                $permissions[$role->getName()] = [];
            }

            foreach ($role->getChildren() as $child) {
                $permissions[$role->getName()] = array_merge($permissions[$role->getName()], $permissions[$child->getName()]);
            }
        }

        return $permissions;
    }


    public function getSecurity(): Security
    {
        if ($this->security) return $this->security;

        $this->security = new Security();
        foreach ($this->roles->findAll() as $role) {
            $this->security->addRole($role, $role->getParents());
        }

        foreach ($this->getPresetPermissions() as $role => $permission) {
            foreach ($permission as $p) {
                $this->security->getRole($role)->addPermission($p);
            }
        }

        foreach (Permission::Query() as $p) {
            $this->security->getRole($p->role)->addPermission($p->value);
        }

        return $this->security;
    }

    public function normalizePath(string $path)
    {
        $path = str_replace(DIRECTORY_SEPARATOR, "/", $path);

        //remove trailing slash
        $path = rtrim($path, "/");

        //remove starting slash
        $path = ltrim($path, "/");


        return "/" . $path;
    }

    private function loadDB()
    {
        $db_config = $this->config["database"];
        if ($db_config) {
            $schema = new Schema(
                $db_config["database"],
                $db_config["hostname"],
                $db_config["username"],
                $db_config["password"],
                $db_config["charset"] ?? "utf8mb4",
                $db_config["port"] ?? 3306,
                $db_config["options"]
            );
        } else {
            $schema = Schema::Create();
        }


        $this->setDbAdapter($schema->getDbAdatpter());
        $this->db = $schema;
        Model::SetSchema($schema);

        $this->db->useEventDispatcher($this->eventDispatcher());
        $this->eventDispatcher()->subscribeListenersFrom(new ListenserSubscriber($this));
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
            $this->modules[] = new Module($this, $module, $this->security, $this->translator);
        }

        //order module
        usort($this->modules, function ($a, $b) {
            return $a->getOrder() <=> $b->getOrder();
        });
    }


    function decodeJWT(string $token)
    {
        return  JWT::decode($token, new Key($_ENV["JWT_SECRET"], "HS256"));
    }



    function getAccessToken(): string
    {

        if ($access_token = $_COOKIE["access_token"]) {

            if ($jwt = $this->decodeJWT($access_token)) {
                //check jti is valid
                if ($this->config["VX"]["jwt_blacklist"] && JWTBlacklist::InList($jwt->jti ?? "")) {
                    return "";
                }
                return $access_token;
            }
        }
        return "";
    }

    function getRefreshToken(): string
    {
        if ($refresh_token = $_COOKIE["refresh_token"]) {
            if ($jwt = $this->decodeJWT($refresh_token)) {
                //check jti is valid
                if ($this->config["VX"]["jwt_blacklist"] && JWTBlacklist::InList($jwt->jti ?? "")) {
                    return "";
                }
                return $refresh_token;
            }
        }
        return "";
    }

    public function processTranslator(string $locale = "en")
    {
        $this->locale = $locale;
        $translator = $this->translator;
        $translator->setLocale($locale);

        if ($locale != "en") {
            if (file_exists($this->vx_root . "/messages.$locale.yml")) {
                $translator->addLoader("yaml", new YamlFileLoader);
                $translator->addResource('yaml', $this->vx_root . "/messages.$locale.yml", $locale);
            }
        }

        //load from db
        $translator->addLoader("array", new ArrayLoader);
        $a = [];

        $q = Translate::Query(["language" => $locale]);
        $q->where->expression("module is null or module=''", []);

        foreach ($q as $t) {
            $a[$t->name] = $t->value;
        }

        //get current module
        $q = Translate::Query(["module" => $this->module->name, "language" => $locale]);
        foreach ($q as $t) {
            $a[$t->name] = $t->value;
        }

        $translator->addResource("array", $a, $locale);
    }

    private function loadConfig()
    {
        $parser = new Parser;
        $config = $parser->parseFile($this->vx_root . "/config.yml");



        $vx_config = $this->config->VX->toArray();
        foreach ($config as $k => $v) {
            if (!isset($vx_config[$k])) {
                $this->config->VX->$k = $v;
            }
        }

        foreach (\VX\Config::Query() as $c) {
            $this->config->VX[$c->name] = $c->value;
        }
    }

    private function loadLanguage()
    {
        $i = 0;
        while ($_ENV["VX_LANGUAGE_{$i}_NAME"]) {
            $this->languages[] = [
                "name" => $_ENV["VX_LANGUAGE_{$i}_NAME"],
                "locale" => $_ENV["VX_LANGUAGE_{$i}_LOCALE"],
            ];
            $i++;
        }

        if (count($this->languages) == 0) {
            $this->languages[] = [
                "name" => "English",
                "locale" => "en",
            ];
        }
    }



    public function getModule(string $name): ?Module
    {
        foreach ($this->getModules() as $module) {
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

        $rp = new PublicKeyCredentialRpEntity($name, $id);
        $source = new PublicKeyCredentialSourceRepository();
        $server = new Webauthn\Server($rp, $source);
        return $server;
    }


    public function invalidateJWT(string $token)
    {
        if ($this->config["VX"]["jwt_blacklist"]) {
            $jwt = $this->decodeJWT($token);
            if ($jwt->jti) {
                JWTBlacklist::Add($jwt->jti, $jwt->exp);
            }
        }
    }


    function getFileSystem(int $index = 0)
    {
        $type = $_ENV["VX_FILE_MANAGER_{$index}"] ?? "local";

        switch ($type) {
            case "local":
                $path = $_ENV["VX_FILE_MANAGER_{$index}_PATH"] ?? $this->root . DIRECTORY_SEPARATOR . "uploads";
                $visibilityConverter = PortableVisibilityConverter::fromArray([
                    'file' => [
                        'public' => 0640,
                        'private' => 0640,
                    ],
                    'dir' => [
                        'public' => 0777,
                        'private' => 0777,
                    ],
                ]);

                $adapter = new League\Flysystem\Local\LocalFilesystemAdapter($path, $visibilityConverter);
                $filesystem = new League\Flysystem\Filesystem($adapter);
                return $filesystem;
                break;
            case "s3":
                $key = $_ENV["VX_FILE_MANAGER_{$index}_KEY"] ?? "";
                $secret = $_ENV["VX_FILE_MANAGER_{$index}_SECRET"] ?? "";
                $region = $_ENV["VX_FILE_MANAGER_{$index}_REGION"] ?? "";
                $bucket = $_ENV["VX_FILE_MANAGER_{$index}_BUCKET"] ?? "";
                $endpoint = $_ENV["VX_FILE_MANAGER_{$index}_ENDPOINT"] ?? "";
                $prefix = $_ENV["VX_FILE_MANAGER_{$index}_PREFIX"] ?? "";

                $client = new Aws\S3\S3Client([
                    'version' => 'latest',
                    'region' => $region,
                    'endpoint' => $endpoint,
                    'use_path_style_endpoint' => true,
                    'credentials' => [
                        'key' => $key,
                        'secret' => $secret,
                    ],
                ]);

                $adapter = new \League\Flysystem\AwsS3V3\AwsS3V3Adapter(
                    $client,
                    $bucket,
                    $prefix,
                    new League\Flysystem\AwsS3V3\PortableVisibilityConverter(
                        // Optional default for directories
                        League\Flysystem\Visibility::PRIVATE // or ::PRIVATE
                    )
                );

                return new League\Flysystem\Filesystem($adapter);
                break;
            case "hostlink-storage":
                $token = $_ENV["VX_FILE_MANAGER_{$index}_TOKEN"] ?? "";
                $endpoint = $_ENV["VX_FILE_MANAGER_{$index}_ENDPOINT"] ?? "";

                $adapter = new HL\Storage\Adapter($token, $endpoint);
                $fs = new League\Flysystem\Filesystem($adapter);
                return $fs;
        }
    }

    /**
     * @deprecated use getFileSystem instead
     */
    public function getFileManager(int $index = 0)
    {
        return $this->getFileSystem($index);
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

    public function generateAccessToken(UserInterface $user)
    {
        $identity = JWT::encode([
            "jti" => Uuid::uuid4()->toString(),
            "type" => "access_token",
            "iat" => time(),
            "exp" => time() + $this->config->VX->access_token_time ?? 3600 * 8,
            "id" => $user->getIdentity()
        ], $_ENV["JWT_SECRET"], "HS256");
        return $identity;
    }

    public function findWebauthnUserByUsername(string $username): ?PublicKeyCredentialUserEntity
    {
        $user = User::Query(["username" => $username])->first();

        if (!$user) return null;

        return new PublicKeyCredentialUserEntity($user->username, $user->user_id, $user->first_name . " " . $user->last_name);
    }

    public function isValidPassword(string $password): bool
    {

        if ($this->config->VX->password_upper_case) {
            if (!preg_match("/[A-Z]/", $password)) {
                return false;
            }
        }

        if ($this->config->VX->password_lower_case) {
            if (!preg_match("/[a-z]/", $password)) {
                return false;
            }
        }

        if ($this->config->VX->password_number) {
            if (!preg_match("/[0-9]/", $password)) {
                return false;
            }
        }

        if ($this->config->VX->password_special_char) {
            if (!preg_match("/[^a-zA-Z0-9]/", $password)) {
                return false;
            }
        }

        if ($this->config->VX->password_min_length) {
            if (strlen($password) < $this->config->VX->password_min_length) {
                return false;
            }
        }
        return true;
    }


    public function getPasswordValidation()
    {
        $validation = [];
        $validation[] = "required";

        if ($this->config->VX->password_upper_case) {
            $validation[] = "containUpper";
        }

        if ($this->config->VX->password_lower_case) {
            $validation[] = "containLower";
        }

        if ($this->config->VX->password_number) {
            $validation[] = "containNumber";
        }

        if ($this->config->VX->password_special_character) {
            $validation[] = "containSpecial";
        }

        if ($this->config->VX->password_length) {
            $validation[] = "length:" . $this->config->VX->password_length;
        }

        return implode("|", $validation);
    }

    public function getPasswordValidationMessages()
    {
        $messages = [];
        if ($this->config->VX->password_length) {
            $messages["length"] = "Password must be at least " . $this->config->VX->password_length . " characters long";
        }

        if ($this->config->VX->password_upper_case) {
            $messages["containUpper"] = "Must contain at least one uppercase letter";
        }

        if ($this->config->VX->password_lower_case) {
            $messages["containLower"] = "Must contain at least one lowercase letter";
        }

        if ($this->config->VX->password_number) {
            $messages["containNumber"] = "Must contain at least one number";
        }

        if ($this->config->VX->password_special_character) {
            $messages["containSpecial"] = "Must contain at least one special character";
        }
        return $messages;
    }


    public function getPasswordPolicy(): array
    {

        return [
            'validation' => $this->getPasswordValidation(),
            'messages' => $this->getPasswordValidationMessages()
        ];
    }

    public function resetPassword(string $password, string $token)
    {
        $payload = JWT::decode($token, new Key($_ENV["JWT_SECRET"], "HS256"));
        $user = User::Load($payload->user_id);

        if (md5($user->password) != $payload->hash) {
            throw new Exception("Reset link is invalid");
        }

        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->save();
    }

    public function forgotPassword(string $username, string $email)
    {
        $user = User::Query(["username" => $username, "email" => $email, "status" => 0])->first();
        if (!$user) return;

        $token = JWT::encode([
            "jti" => Uuid::uuid4()->toString(),
            "type" => "access_token",
            "iat" => time(),
            "exp" => time() + 3600,
            "id" => $user->user_id,
        ], $_ENV["JWT_SECRET"], "HS256");

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
        $twig->addExtension(new TranslationExtension($this->translator));

        return $twig;
    }

    public function getMailer()
    {
        $mailer = new Mailer();
        if ($mail_from = $this->config["VX"]["mail_from"]) {
            $mailer->setFrom($mail_from);
        }


        if ($this->config["VX"]["smtp"]) {
            $mailer->isSMTP();
            $mailer->Host = $this->config["VX"]["smtp_host"];
            if ($this->config["VX"]["smtp_auth"]) {
                $mailer->SMTPAuth = true;
            }
            $mailer->Username = $this->config["VX"]["smtp_username"];
            $mailer->Password = $this->config["VX"]["smtp_password"];
            $mailer->SMTPSecure = $this->config["VX"]["smtp_secure"];
            $mailer->Port = $this->config["VX"]["smtp_port"];
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

    function getServiceManager()
    {
        return $this->service;
    }

    // login with username, password and code, throw exception if failed
    function login()
    {
        $adatper = $this->service->get(AdapterInterface::class);
        $result = $this->auth->authenticate($adatper);

        if (!$result->isValid()) {
            //failed
            throw new Exception($result->getMessages()[0], 401);
        }

        return $result->getIdentity();
    }

    public function logout()
    {
        //get last logout
        $o = UserLog::Query([
            "user_id" => $this->user_id
        ])->order("userlog_id desc")->first();

        if ($o) {
            $o->logout_dt = date("Y-m-d H:i:s");
            $o->save();
        }
    }

    /**
     * @return Module[]
     */
    public function getModules()
    {
        return $this->modules;
    }

    function getRequestHandler(string $file)
    {
        return \PUXT\RequestHandler::Create($file);
    }

    function createSchema()
    {
        return new \FormKit\SchemaNode($this->translator);
    }
}
