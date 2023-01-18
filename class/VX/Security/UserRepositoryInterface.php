<?php

namespace VX\Security;

interface UserRepositoryInterface
{

    /**
     * @return UserInterface[]
     */
    public function all(): array;
    public function authenticate(string $identity, ?string $credential): ?UserInterface;
}
