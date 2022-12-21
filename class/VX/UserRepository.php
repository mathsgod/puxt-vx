<?php

namespace VX;

use Laminas\Authentication\Adapter\AdapterInterface;
use VX\Authentication\Adapter;
use VX\Security\UserInterface;
use VX\Authentication\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function authenticate(string $credential, ?string $password = null): ?UserInterface
    {
        return User::Query(["username" => $credential])->first();
    }


    public function all(): array
    {
        return User::Query()->toArray();
    }

    public function getAuthenticationAdatper(string $identity, ?string $crdential = null, ?string $code = null): ?AdapterInterface
    {
        return new Adapter($identity, $crdential, $code);
    }
}
