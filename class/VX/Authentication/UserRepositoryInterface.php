<?php

namespace VX\Authentication;

use VX\Security\UserInterface;

interface UserRepositoryInterface
{

    /**
     * @return UserInterface[]
     */
    public function all(): array;
    public function authenticate(string $identity, ?string $credential): ?UserInterface;
}
