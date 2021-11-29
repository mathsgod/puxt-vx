<?php

namespace VX;

use Laminas\Diactoros\ResponseFactory;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PUXT\Loader;
use VX;

class ModuleFile implements ResourceInterface, RequestHandlerInterface
{
    public string $path;
    public string $file;

    public function __construct(Module $module, string $path, string $file)
    {
        $this->module = $module;
        $this->path = $path;
        $this->file = $file;
    }

    function getResourceId()
    {
        return $this->path;
    }

    function handle(ServerRequestInterface $request): ResponseInterface
    {

        $loader = $this->module->vx->getRequestHandler($this->file);
        return $loader->handle($request);
    }

    function __debugInfo()
    {
        return [
            'path' => $this->path,
            'file' => $this->file,
        ];
    }
}
