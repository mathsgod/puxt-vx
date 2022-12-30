<?php

namespace VX;

use Laminas\Permissions\Rbac\Rbac;
use Laminas\Permissions\Rbac\RoleInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ModuleFile implements RequestHandlerInterface
{
    public string $path;
    public string $file;

    public function __construct(Module $module, string $path, string  $file)
    {
        $this->module = $module;
        $this->path = $path;
        $this->file = $file;
    }
    
    function handle(ServerRequestInterface $request): ResponseInterface
    {

        $user = $request->getAttribute("user");
        //        $acl = $request->getAttribute("acl");

        /*       if (!$user instanceof RoleInterface) {
            throw new BadRequestException();
        } */
        /* 
        if (!$acl instanceof AclInterface) {
            throw new BadRequestException();
        }


        if (!$acl->isAllowed($user, $this->getResourceId())) {
            throw new ForbiddenException();
        }
 */
        /*         if ($request->getMethod() == "GET") {

            //check accept header has text/vue
            $accept = $request->getHeaderLine("Accept");
            if (strpos($accept, "text/vue") !== false && file_exists($this->file . ".vue")) {

                $handler = new VueRequestHandler($this->file . ".vue");
                return $handler->handle($request);
            }
        }
 */
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
