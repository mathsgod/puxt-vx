<?php

use Laminas\Permissions\Rbac\RoleInterface;
use VX\Model;

class Role extends Model implements RoleInterface
{
    /**
     * @var \Laminas\Permissions\Rbac\Role
     */
    private $_role;

    private function getRole()
    {
        if ($this->_role) {
            return $this->_role;
        }
        return $this->_role = new \Laminas\Permissions\Rbac\Role($this->name);
    }

    public function addPermission(string $name): void
    {
        $this->getRole()->addPermission($name);
    }

    public function hasPermission(string $name): bool
    {
        return $this->getRole()->hasPermission($name);
    }

    public function addChild(RoleInterface $child): void
    {
        $this->getRole()->addChild($child);
    }

    public function addParent(RoleInterface $parent): void
    {
        $this->getRole()->addParent($parent);
    }

    public function getChildren(): iterable
    {
        return $this->getRole()->getChildren();
    }

    public function getParents(): iterable
    {
        return $this->getRole()->getParents();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
