<?php

namespace VX\Authentication;

use Laminas\Authentication\Adapter\AdapterInterface;

interface UserRepositoryInterface
{

    public function getUserByIdentity(string $identity): ?UserInterface;

    /**
     * @return UserInterface[]
     */
    public function getAll(): array;

    public function getAuthenticationAdatper(string $identity, ?string $crdential, ?string $code): ?AdapterInterface;
}
