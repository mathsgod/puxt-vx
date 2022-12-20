<?php

namespace VX;

use Laminas\Permissions\Rbac\AssertionInterface;
use VX\Authentication\UserInterface;

interface ModelInterface extends AssertionInterface
{
    public function canReadBy(UserInterface $user): bool;
    public function canDeleteBy(UserInterface $user): bool;
    public function canUpdateBy(UserInterface $user): bool;
    public function canCreateBy(UserInterface $user): bool;

    public function uri(?string $name = null): string;

    public function save();
    public function delete();
    public function bind($obj);
    static function Load(int $id): ?static;

    public function _id();
}
