<?php

namespace VX\Security;

use InvalidArgumentException;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Permissions\Rbac\Role;
use Laminas\Permissions\Rbac\RoleInterface;

class Security
{

    /**
     * @var Rbac
     */
    private $rbac;

    public function __construct()
    {
        $this->rbac = new Rbac();
        $this->rbac->setCreateMissingRoles(true);
        $this->rbac->getCreateMissingRoles(true);
    }

    public function getRbac()
    {
        return $this->rbac;
    }

    public function getRole(string $roleName): RoleInterface
    {
        return $this->rbac->getRole($roleName);
    }

    /**
     * Add a child.
     *
     * @param  string|RoleInterface $role
     * @param  null|array|RoleInterface $parents
     */
    public function addRole($role, $parents = null): void
    {
        if (is_string($role)) {
            $role = new Role($role);
        }
        if ($this->hasRole($role)) return;

        $this->rbac->addRole($role, $parents);
    }

    /**
     * Is a role registered?
     *
     * @param  RoleInterface|string $role
     */
    public function hasRole($role): bool
    {
        return $this->rbac->hasRole($role);
    }

    public function isGranted(UserInterface $user, string $permission, $assertion = null): bool
    {
        if ($assertion) {
            if (
                !$assertion instanceof AssertionInterface
                && !is_callable($assertion)
            ) {
                throw new InvalidArgumentException(
                    'Assertions must be a Callable or an instance of Laminas\Permissions\Rbac\AssertionInterface'
                );
            }

            if ($assertion instanceof AssertionInterface) {
                return $assertion->assert($this, $user, $permission);
            }

            // Callable assertion provided.
            return  $assertion($this, $user, $permission);
        }

        foreach ($user->getRoles() as $role) {
            if ($this->rbac->isGranted($role, $permission)) {
                return true;
            }
        }

        return false;
    }
}
