<?php

namespace VX\Route\Strategy;

use Laminas\Diactoros\Response\EmptyResponse;
use League\Route\Http\Exception\{MethodNotAllowedException, NotFoundException};
use League\Route\Route;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use VX;

class ApplicationStrategy extends \League\Route\Strategy\ApplicationStrategy
{
    public function __construct(VX $vx)
    {
        $this->vx = $vx;
    }

    public function getNotFoundDecorator(NotFoundException $exception): MiddlewareInterface
    {

        return new class($exception, $this->vx) implements MiddlewareInterface
        {
            private $exception;
            private $vx;

            public function __construct(NotFoundException $exception, VX $vx)
            {
                $this->exception = $exception;
                $this->vx = $vx;
            }

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {
                return new EmptyResponse(404);
                $handler = $this->vx->getRequestHandler($this->vx->vx_root . "/pages/error");
                return $handler->handle($request);
            }
        };
    }
}
