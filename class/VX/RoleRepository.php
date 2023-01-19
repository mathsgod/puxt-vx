<?php

namespace VX;

use Laminas\Permissions\Rbac\Role;
use Laminas\Permissions\Rbac\RoleInterface;
use VX\Security\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * @var Role[]
     */
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

            if ($role->child) {

                if (!$roles[$role->child]) {
                    $roles[$role->child] = new Role($role->child);
                }

                $roles[$role->name]->addChild($roles[$role->child]);
            }
        }
        $this->roles = array_values($roles);
    }

    function findAll(): iterable
    {
        return $this->roles;
    }

    function delete(RoleInterface $role): void
    {
        $name = $role->getName();
        
        foreach (\VX\Role::Query(["name" => $name]) as $role) {
            $role->delete();
        }

        foreach (\VX\Role::Query(["child" => $name]) as $role) {
            $role->delete();
        }
    }

    function findById($id): ?RoleInterface
    {
        foreach ($this->roles as $role) {
            if ($role->getName() == $id) {
                return $role;
            }
        }
        return null;
    }

    function save(RoleInterface $role): void
    {
        $r = \VX\Role::Query(["name" => $role->getName()])->first();
        if (!$r) {
            $r = new \VX\Role();
            $r->name = $role->getName();
        }

        $r->child = null;
        foreach ($role->getChildren() as $child) {
            $r->child = $child->getName();
        }

        $r->save();
    }
}
