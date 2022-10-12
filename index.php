<?php

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\Stream;
use League\Glide\Responses\PsrResponseFactory;
use League\Route\Http\Exception\NotFoundException;
use League\Route\RouteGroup;
use League\Route\Router;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;

return function ($options) {

    $vx = new VX($this->puxt);

    $this->puxt->vx = $vx;


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

    $router->addPatternMatcher("any", ".+");

    $base = substr($vx->base_path, 0, -1);

    $router->group($base, function (RouteGroup $route) use ($vx) {
        foreach ($vx->getModules() as $module) {
            $module->setupRoute($route);
        }
    });

    $router->map("OPTIONS", $vx->base_path . "{any:.*}", function (ServerRequestInterface $request) {

        $response = new EmptyResponse(200);
        $response = $response->withAddedHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
        $response = $response->withAddedHeader("Access-Control-Allow-Headers", "Content-Type, Authorization, X-Requested-With, vx-view-as");
        $response = $response->withAddedHeader("Access-Control-Allow-Credentials", "true");
        return $response;
    });


    $router->map("GET", $vx->base_path . "drive/{id:number}/{file:any}", function (ServerRequestInterface $serverRequest, array $args) use ($vx) {

        //B5 Broken Access Control 
        if (!$vx->logined) {
            return new EmptyResponse(401);
        }

        $fm = $vx->getFileSystem($args["id"]);
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

        //B5 Broken Access Control 
        if (!$vx->logined) {
            return new EmptyResponse(401);
        }

        $glide = League\Glide\ServerFactory::create([

            "source" => $vx->getFileSystem($args["id"]),
            "cache" => dirname($vx->root) . DIRECTORY_SEPARATOR . "cache",
            "response" => new PsrResponseFactory(new Response(), function ($stream) {
                return new Stream($stream);
            }),
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


    $router->map("GET", $vx->base_path . "cancel-view-as", function (ServerRequestInterface $request) use ($vx) {
        $handler =  $vx->getRequestHandler($vx->vx_root . "/pages/cancel-view-as");
        return $handler->handle($request);
    });

    $router->map("GET",  $vx->base_path . "error", function (ServerRequestInterface $request) use ($vx) {
        $handler = $vx->getRequestHandler($vx->vx_root . "/pages/error");
        return $handler->handle($request);
    });




    $this->puxt->setRouter($router);
};
