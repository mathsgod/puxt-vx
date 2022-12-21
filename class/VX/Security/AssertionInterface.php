<?php
namespace VX\Security;
use VX\Security\Security;
use VX\Security\UserInterface;

interface AssertionInterface
{
    /**
     * Assertion method - must return a boolean.
     */
    public function assert(Security $security, UserInterface $user, string $permission): bool;
}
