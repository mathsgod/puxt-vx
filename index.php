<?php

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequest;
use League\Route\Http\Exception\ForbiddenException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\RouteGroup;
use League\Route\Router;
use Monolog\Logger;
use PHP\Psr7\Stream;
use PHP\Psr7\StringStream;
use Psr\Http\Message\ServerRequestInterface;

return function ($options) {
    if ($this->puxt->request->getMethod() == "OPTIONS") {
        http_response_code(200);
        exit;
    }

    $vx = new VX($this->puxt);

    $config = $this->puxt->config["VX"];

    if ($logger_config = $config["logger"]) {
        $logger = new Logger("vx");
        foreach ($logger_config as $log) {
            $logger->pushHandler(new \Monolog\Handler\StreamHandler($log["path"], $log["level"]));
        }
        $vx->setLogger($logger);
    }


    $router = new Router();
    $router->setStrategy(new \VX\Route\Strategy\ApplicationStrategy($vx));
    $router->middleware($vx);

    $router->addPatternMatcher("any", "[a-zA-Z0-9\%\./]+");


    $base = substr($vx->base_path, 0, -1);

    $router->group($base, function (RouteGroup $route) use ($vx) {
        foreach ($vx->getModules() as $module) {
            foreach ($module->getRouterMap() as $map) {
                $handler = $map["handler"];
                $file = $map["file"];
                $path = $map["path"];


                if ($handler instanceof \Closure) {
                    $route->map($map["method"], $path, $handler);
                    continue;
                }

                $path = str_replace("@", ":", $path);

                $route->map($map['method'],  $path, function (ServerRequestInterface $request, array $args) use ($vx, $handler, $file, $path, $module) {
                    $context = $request->getAttribute("test", new stdClass);
                    $context->params = $args;
                    $request = $request->withAttribute("test", $context);

                    $resource_id = $handler->getResourceId();
                    if (!$vx->getAcl()->isAllowed($vx->user, $resource_id)) {
                        throw new ForbiddenException();
                    }
                    $vx->object_id = $args["id"];
                    $vx->module = $module;

                    $twig = $vx->getTwig(new \Twig\Loader\FilesystemLoader(dirname($file)));
                    $request = $request->withAttribute("twig", $twig);

                    $vx->request_uri = $path;

                    return $handler->handle($request);
                });
            }
        }
    });

    $router->map("GET", $vx->base_path . "drive/{id:number}/{file:any}", function (ServerRequestInterface $serverRequest, array $args) use ($vx) {
        $fm = $vx->getFileManager();
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


    $router->map("GET", $vx->base_path . "photo/{id:number}/{file:any}", function (ServerRequestInterface $request, array $args) use ($vx) {
        $glide = League\Glide\ServerFactory::create([
            "source" => $vx->getFileManager()
        ]);
        return  $glide->getImageResponse($args["file"], $request->getQueryParams());
    });


    $router->map("GET",  $vx->base_path, function (ServerRequestInterface $request) use ($vx) {
        $handler = $vx->getRequestHandler($vx->vx_root . "/pages/index");
        return $handler->handle($request);
    });

    $router->map("POST",  $vx->base_path, function (ServerRequestInterface $request) use ($vx) {
        $handler = $vx->getRequestHandler($vx->vx_root . "/pages/index");
        return $handler->handle($request);
    });

    $router->map("POST",  $vx->base_path . "login", function (ServerRequestInterface $request) use ($vx) {
        $handler =  $vx->getRequestHandler($vx->vx_root . "/pages/login");
        return $handler->handle($request);
    });

    $router->map("GET", $vx->base_path . "cancel-view-as", function (ServerRequestInterface $request) use ($vx) {
        $twig = $vx->getTwig(new \Twig\Loader\FilesystemLoader($vx->vx_root . "/pages"));
        $request = $request->withAttribute("twig", $twig);

        $handler =  $vx->getRequestHandler($vx->vx_root . "/pages/cancel-view-as");
        return $handler->handle($request);
    });

    $router->map("GET",  $vx->base_path . "error", function (ServerRequestInterface $request) use ($vx) {
        $twig = $vx->getTwig(new \Twig\Loader\FilesystemLoader($vx->vx_root . "/pages"));
        $request = $request->withAttribute("twig", $twig);

        $handler = $vx->getRequestHandler($vx->vx_root . "/pages/error");
        return $handler->handle($request);
    });




    $this->puxt->setRouter($router);
};
