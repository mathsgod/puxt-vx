<?php

use Complex\Exception;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequest;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\FileAttributes;
use League\Flysystem\StorageAttributes;
use League\Route\Router;
use Psr\Http\Message\ServerRequestInterface;
use PUXT\App;
use R\DB\Schema;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Yaml\Parser;
use VX\Model;
use VX\Config;
use VX\Module;
use VX\TwigI18n;
use VX\User;
use VX\UserGroup;

return function ($options) {
    if ($this->puxt->request->getMethod() == "OPTIONS") {
        http_response_code(200);
        exit;
    }
    

    $vx = new VX($this->puxt);



    $router = new Router();
    foreach ($vx->getModules() as $module) {
        foreach ($module->getRouterMap() as $map) {

            $handler = $map["handler"];
            $router->map($map['method'], "/vx/" . $map['path'], function (ServerRequestInterface $request) use ($vx, $handler) {
                return $vx->process($request, $handler);
            });
        }
    }
    

    $router->map("GET", "/vx/", function (ServerRequestInterface $request) use ($vx) {
        return $vx->process($request, $vx->getRequestHandler($vx->vx_root . "/pages/index.php"));
    });

    $router->map("POST", "/vx/login", function (ServerRequestInterface $request) use ($vx) {
        return $vx->process($request, $vx->getRequestHandler($vx->vx_root . "/pages/login.php"));
    });

    $router->map("GET", "/vx/login", function (ServerRequestInterface $request) use ($vx) {
        return $vx->process($request, $vx->getRequestHandler($vx->vx_root . "/pages/login.php"));
    });


    $this->puxt->setRouter($router);
    return;



    $this->puxt->hook('ready', function (App $puxt) use ($vx) {


        $vx->init($puxt->context);

        outp($vx->getModules());
        die();

        $restHandler = function (ServerRequestInterface $requeset) {
        };

        $pageHandler = function (ServerRequestInterface $request) {
        };

        //

        $getRouterMap = function (string $base) use ($restHandler, $pageHandler) {
            $adapter = new \League\Flysystem\Local\LocalFilesystemAdapter($base);
            $fs = new \League\Flysystem\Filesystem($adapter);

            $dirs = $fs->listContents('/')->filter(function (StorageAttributes $attributes) {
                return $attributes->isDir();
            })->toArray();

            $map = [];
            foreach ($dirs as $dir) {

                $module = new Module($dir->path());

                $map[$dir->path()]["GET"] = $restHandler;
                $map[$dir->path()]["POST"] = $restHandler;
                $map[$dir->path()]["DELETE"] = $restHandler;
                $map[$dir->path()]["PATCH"] = $restHandler;

                if (
                    $fs->fileExists($dir->path() . DIRECTORY_SEPARATOR . "index.php") ||
                    $fs->fileExists($dir->path() . DIRECTORY_SEPARATOR . "index.html") ||
                    $fs->fileExists($dir->path() . DIRECTORY_SEPARATOR . "index.twig")
                ) {

                    $map[$dir->path() . "/"]["GET"] = $pageHandler;
                }


                $files = $fs->listContents($dir->path(), true)->filter(function (StorageAttributes $attributes) {
                    return $attributes->isFile();
                })->filter(function (FileAttributes $attributes) {
                    $path = $attributes->path();
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    return $ext == "php" || $ext == "html" || $ext == "twig";
                })->toArray();

                //group files
                $group_files = [];
                foreach ($files as $file) {
                    $path = $file->path();
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $path = substr($path, 0, - (strlen($ext) + 1));
                    $group_files[$path] = $file;
                }

                foreach ($group_files as $path => $file) {
                    //remove dir from path
                    $path = substr($path, strlen($dir->path()) + 1);

                    $map[$dir->path() . "/" . $path]["GET"] = $pageHandler;
                }
            }

            //root files

            $adapter = new \League\Flysystem\Local\LocalFilesystemAdapter($base);
            $fs = new \League\Flysystem\Filesystem($adapter);

            $files = $fs->listContents('/')->filter(function (StorageAttributes $attributes) {
                return $attributes->isFile();
            })->filter(function (FileAttributes $attributes) {
                $path = $attributes->path();
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                return $ext == "php" || $ext == "html" || $ext == "twig";
            })->map(function (FileAttributes $attributes) {
                return [
                    "path" => $attributes->path(),
                ];
            })->toArray();
            foreach ($files as $file) {
                $path = $file["path"];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $path = substr($path, 0, - (strlen($ext) + 1));
                $map[$path] = [
                    "path" => $path,
                    "base" => $base
                ];
            }


            return $map;
        };

        //$map = $getRouterMap($this->puxt->root . DIRECTORY_SEPARATOR . "pages");
        $map = $getRouterMap(__DIR__ . DIRECTORY_SEPARATOR . "pages");

        $map = array_merge($map, $getRouterMap($this->puxt->root . DIRECTORY_SEPARATOR . "pages"));

        outp($map);
        die();
        $router = new Router();



        $router->map("GET", "/vx/", function (ServerRequestInterface $request) {

            $response = (new ResponseFactory)->createResponse();
            $response = $response->withBody(new PHP\Psr7\StringStream("<h1>VX</h1>"));
            return $response;
        });
        $puxt->setRouter($router);

        return;

        $puxt->response = $puxt->response
            ->withHeader("Access-Control-Allow-Credentials", "true")
            ->withHeader("Access-Control-Allow-Headers", "Content-Type, Authorization, vx-view-as, rest-jwt")
            ->withHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS, PUT, PATCH, HEAD, DELETE")
            ->withHeader("Access-Control-Expose-Headers", "location, Content-Location");

        if ($_SERVER["HTTP_ORIGIN"]) {
            $puxt->response = $puxt->response->withHeader("Access-Control-Allow-Origin", $_SERVER["HTTP_ORIGIN"]);
        }

        Model::$_vx = $vx;

        $vx->init($puxt->context);

        $i18n = new TwigI18n;
        $i18n->setTranslator($vx->getTranslator());
        $puxt->addExtension($i18n);


        $puxt->context = $vx;

        $vx->db = $schema;


        $parser = new Parser();
        foreach ($parser->parseFile(__DIR__ . "/default.config.yml") as $k => $v) {
            $vx->config["VX"][$k] = $v;
        }

        foreach (Config::Query() as $config) {
            $vx->config["VX"][$config->name] = $config->value;
        }

        $path = $puxt->context->route->path;
        $org_path = $puxt->context->route->path;

        if ($path == "") {
            $path = "index";
        }

        if (substr($path, -1) == "/") {
            $path .= "index";
        } else {
            if (is_dir("pages" . DIRECTORY_SEPARATOR . $path) || is_dir(__DIR__ . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $path)) {
                $path .= "/index";
            }
        }


        $vx->request_uri = $path;
        // skip id
        $t = [];
        $id = null;

        foreach (explode("/", $path) as $q) {
            if (is_numeric($q)) {
                $ids[] = $q;
                if (!$id) {
                    $id = $q;
                }
                continue;
            }
            $t[] = $q;
        }

        $vx->object_id = $id;

        $path = implode("/", $t);
        $puxt->context->route->path = $path;

        $module = $vx->module;
        if (!$module->name) {
            $module = null;
        }

        //--- REST ---
        //get
        if (
            $vx->request->getMethod() == "GET"
            && $module
            && $vx->object_id
            && (($module->name . "/" . $vx->object_id) == $org_path)
        ) {

            $obj = $module->getObject($vx->object_id);

            if (!$obj->canReadBy($vx->user)) {
                throw new Exception("Forbidden", 403);
            }
            header("Content-Type: application/json");
            header("Content-Location: " . $obj->uri());
            echo json_encode($obj, JSON_UNESCAPED_UNICODE);
            exit();
        }

        //create
        if (
            $vx->request->getMethod() == "POST"
            && strstr($vx->request->getHeader("Content-Type")[0], "application/json")
            && $module
            && !$vx->object_id
            && $module->name == $org_path
        ) {
            if (!$vx->logined) {
                throw new Exception("Unauthorized", 401);
            }

            $obj = $module->createObject();
            $obj->bind($vx->request->getParsedBody());
            $obj->save();

            $id = $obj->_id();
            http_response_code(201);
            header("Content-Location: " . $obj->uri());
            exit();
        }

        if (
            $vx->request->getMethod() == "PATCH"
            && strstr($vx->request->getHeader("Content-Type")[0], "application/json")
            && $vx->object_id
            && (($module->name . "/" . $vx->object_id) == $org_path)
        ) {
            if (!$vx->logined) {
                throw new Exception("Unauthorized", 401);
            }

            $obj = $module->getObject($vx->object_id);

            if (!$obj->canUpdateBy($vx->user)) {
                throw new Exception("Forbidden", 403);
            }

            $obj->bind($vx->request->getParsedBody());
            $obj->save();

            header("Content-Location: " . $obj->uri());
            http_response_code(204);
            exit();
        }

        if ($vx->request->getMethod() == "DELETE") {

            if (!$vx->logined) {
                throw new Exception("Unauthorized", 401);
            }

            if ($obj = $vx->object()) {
                if (!$obj->canDeleteBy($vx->user)) {
                    throw new Exception("Forbidden", 403);
                }
                $obj->delete();
                http_response_code(204);
                exit;
            } else {
                throw new Exception("Not Found", 404);
            }
        }

        if ($vx->getAcl()->hasResource($path)) {
            //check permission
            if (!$vx->getAcl()->isAllowed($vx->user, $path)) {
                if ($vx->logined) {
                    throw new Exception("Forbidden", 403);
                } else {
                    throw new Exception("Unauthorized", 401);
                }
            }

            $globs = glob("pages/" . $path . ".*");
            if (count($globs)) {
                return;
            }
            $this->puxt->config["dir"]["pages"] = "vendor/mathsgod/puxt-vx/pages";
        }
    });

    $this->puxt->hook("render:before", function ($page) use ($vx) {

        $content = $page->render("");

        if (strstr($vx->request->getHeaderLine("accept"), "*/*") && $content) {
            echo $content;
            die();
        }
    });
};
