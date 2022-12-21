<?php

namespace VX\Security;

interface UserInterface
{
    public function getIdentity(): string;

    /**
     * @return string[]
     */
    public function getRoles(): array;


    public function is(string $role): bool;
}
