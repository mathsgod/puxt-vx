<?php

namespace VX\Authentication;

use Laminas\Permissions\Rbac\RoleInterface;

interface UserInterface
{
    public function getIdentity(): string;

    /**
     * @return RoleInterface[]
     */
    public function getRoles(): array;
}
