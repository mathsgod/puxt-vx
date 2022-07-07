<?php

namespace VX;

interface MenuItemsInterface
{
    public function getMenuItemByUser(User $user): array;
}
