<?php

namespace VX\Security;

use Psr\Http\Message\ServerRequestInterface;
use VX\Security\UserInterface;

interface AuthenticationInterface
{
    public function authenticate(ServerRequestInterface $requeset): ?UserInterface;
}
