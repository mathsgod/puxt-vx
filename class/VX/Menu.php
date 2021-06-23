<?php

namespace VX;

class Menu
{
    public $items = [];
    public $groups = [];
    public function addModule(Module $module)
    {
        if ($module->group) {
            if (!$mg = $this->groups[$module->group]) {
                $mg = new ModuleGroup($module->group);
                $this->groups[$module->group] = $mg;
                $this->items[] = $mg;
            }
            $mg->add($module);
        } else {
            $this->items[] = $module;
        }
    }


    public function getMenuByUser(User $user)
    {
        $data = [];
        foreach ($this->items as $item) {
            $menu = $item->getMenuItemByUser($user);

            if (count($menu["submenu"]) == 0 && $menu["link"] == "#") continue;

            $data[] = $menu;
        }
        return $data;
    }
}
