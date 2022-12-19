<?php

namespace VX\Authentication;

interface UserInterface
{
    public function getIdentity(): string;
    public function getRoles(): array;
    public function getName(): string;
}
