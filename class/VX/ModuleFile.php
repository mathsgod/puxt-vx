<?php

namespace VX;

use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ModuleFile implements ResourceInterface, RequestHandlerInterface
{
    public string $path;
    public string $file;

    public function __construct(Module $module, string $path, string  $file)
    {
        $this->module = $module;
        $this->path = $path;
        $this->file = $file;
    }

    function getResourceId()
    {
        return $this->module->name . "/" . $this->path;
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
            'file' => $this->file
        ];
    }
}
