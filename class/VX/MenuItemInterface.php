<?php

namespace VX;

use VX\Authentication\UserInterface;

interface MenuItemInterface
{
    public function getMenuItemByUser(UserInterface $user): array;

    public function getLabel(): string;
    public function getIcon(): string;
    public function getLink(): ?string;
}
