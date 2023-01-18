<?php

namespace VX;

use VX\Security\UserInterface;
use VX\Security\UserRepositoryInterface;

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
}
