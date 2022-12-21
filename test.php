<?php

use Laminas\Permissions\Rbac\RoleInterface;
use VX\Security\AssertionInterface;
use VX\Security\Role;
use VX\Security\Security;
use VX\Security\UserInterface;

require_once __DIR__ . '/vendor/autoload.php';

$sec = new Security;


$sec->addRole('user');

$sec->getRole('user')->addPermission('create');


class User implements UserInterface
{
    public function getIdentity(): string
    {
        return 1;
    }

    public function getRoles(): array
    {
        return ["user"];
    }

    public function is(string $role): bool
    {
        if ($role === "user") return true;
        return false;
    }
}

$user = new User();

class O implements AssertionInterface
{
    function assert(Security $security, UserInterface $user, string $permission): bool
    {
        if ($permission == "create") {
            return false;
        }
        if ($permission == "delete") {
            return true;
        }
        return false;
    }
}

echo $sec->isGranted($user, "create");
