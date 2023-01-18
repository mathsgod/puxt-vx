<?php

namespace VX\Security;

use Laminas\Permissions\Rbac\RoleInterface;
interface RoleRepositoryInterface
{
    /**
     * @return RoleInterface[]
     */
    public function all(): array;
}
