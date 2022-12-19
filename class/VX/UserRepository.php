<?php

namespace VX;

use Laminas\Authentication\Adapter\AdapterInterface;
use VX\Authentication\Adapter;
use VX\Authentication\UserInterface;
use VX\Authentication\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function getUserByIdentity(string $identity): ?UserInterface
    {
        return User::Query(["username" => $identity])->first();
    }

    public function getAll(): array
    {
        return User::Query()->toArray();
    }

    public function getAuthenticationAdatper(string $identity, ?string $crdential, ?string $code): ?AdapterInterface
    {
        return new Adapter($identity, $crdential, $code);
    }
}
