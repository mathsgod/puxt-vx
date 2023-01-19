<?php

namespace VX;

use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VX\Security\AssertionInterface;
use VX\Security\Security;
use VX\Security\UserInterface;

class ModuleFile implements RequestHandlerInterface, AssertionInterface
{
    public string $path;
    public string $file;
    public $module;

    public function __construct(Module $module, string $path, string  $file)
    {
        $this->module = $module;
        $this->path = $path;
        $this->file = $file;
    }

    public function assert(Security $security, UserInterface $user, string $permission): bool
    {
        if ($user->is("Administrators")) {
            return true;
        }

        return $security->isGranted($user, $permission);
    }

    function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Security $security */
        $security = $request->getAttribute(Security::class);

        if (!$security->isGranted($request->getAttribute(UserInterface::class), $this->module->name . "/" . $this->path, $this)) {
            return new HtmlResponse("Access Denied: " . $this->module->name . "/" . $this->path, 403, ["Content-Type" => "text/plain; charset=utf-8"]);
        }

        return \PUXT\RequestHandler::Create($this->file)->handle($request);
    }

    function __debugInfo()
    {
        return [
            'path' => $this->path,
            'file' => $this->file,
        ];
    }
}
