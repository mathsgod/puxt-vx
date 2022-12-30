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
    }

    public function getRole(string $roleName): RoleInterface
    {
        return $this->rbac->getRole($roleName);
    }

    public function addRole($role, $parents = null): void
    {
        if (is_string($role)) {
            $role = new Role($role);
        }

        $this->rbac->addRole($role, $parents);
    }

    public function hasRole($role): bool
    {
        return $this->rbac->hasRole($role);
    }

    public function isGranted(UserInterface $user, string $permission, $assertion = null): bool
    {
        /*    if (!$this->hasRole($role)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'No role with name "%s" could be found',
                is_object($role) ? $role->getName() : $role
            ));
        } */

        if ($user->is("Administrators")) {
            return true;
        }

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


            if ($this->rbac->isGranted($role, $permission, $assertion)) {
                return true;
            }
        }

        return false;
    }
}
