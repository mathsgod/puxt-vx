<?php

namespace VX\Security;

use Laminas\Permissions\Rbac\RoleInterface;


interface RoleRepositoryInterface
{
    /**
     * @return iterable<RoleInterface>
     */
    public function findAll(): iterable;

    public function delete(RoleInterface $role): void;

    public function findById($id): ?RoleInterface;

    public function save(RoleInterface $role): void;
}
