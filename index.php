<?php

use League\Route\Http\Exception\ForbiddenException;
use League\Route\RouteGroup;
use League\Route\Router;
use Psr\Http\Message\ServerRequestInterface;

return function ($options) {
    if ($this->puxt->request->getMethod() == "OPTIONS") {
        http_response_code(200);
        exit;
    }

    $vx = new VX($this->puxt);

 

    $router = new Router();
    $router->middleware($vx);

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

                $route->map($map['method'],  $path, function (ServerRequestInterface $request, array $args) use ($vx, $handler, $file, $path, $module) {
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
