<?php

namespace VX;

use Laminas\Permissions\Acl\AclInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Laminas\Permissions\Acl\Role\RoleInterface;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\ForbiddenException;
use League\Route\Http\Exception\UnauthorizedException;
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

        $user = $request->getAttribute("user");
        $acl = $request->getAttribute("acl");

        if (!$user instanceof RoleInterface) {
            throw new BadRequestException();
        }

        if (!$acl instanceof AclInterface) {
            throw new BadRequestException();
        }


        if (!$acl->isAllowed($user, $this->getResourceId())) {

            if ($this->module->vx->logined) {
                throw new ForbiddenException();
            } else {
                throw new UnauthorizedException();
            }
        }

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
