<?php

namespace VX\Authentication;

use Psr\Http\Message\ServerRequestInterface;

interface AuthenticationInterface
{
    public function authenticate(ServerRequestInterface $requeset): ?UserInterface;
}
