<?php

namespace VX;

interface MenuItemInterface
{
    public function getMenuItemByUser(User $user): array;

    public function getLabel(): string;
    public function getIcon(): string;
    public function getLink(): ?string;
}
