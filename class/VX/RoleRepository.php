<?php

namespace VX;

use Laminas\Permissions\Rbac\Role;
use VX\Security\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    private array $roles = [];

    public function __construct()
    {
        $roles = [];
        $roles["Administrators"] = new Role("Administrators");
        $roles["Users"] = new Role("Users");
        $roles["Power Users"] = new Role("Power Users");
        $roles["Guests"] = new Role("Guests");
        $roles["Everyone"] = new Role("Everyone");

        $roles["Everyone"]->addParent($roles["Guests"]);
        $roles["Everyone"]->addParent($roles["Users"]);
        $roles["Everyone"]->addParent($roles["Power Users"]);
        $roles["Everyone"]->addParent($roles["Administrators"]);


        foreach (\VX\Role::Query() as $role) {
            if (!$roles[$role->name]) {
                $roles[$role->name] = new Role($role->name);
            }

            if ($role->parent) {

                if (!$roles[$role->parent]) {
                    $roles[$role->parent] = new Role($role->parent);
                }

                $roles[$role->parent]->addParent($roles[$role->name]);
            }
        }
        $this->roles = array_values($roles);
    }

    function all(): array
    {
        return $this->roles;
    }
}
