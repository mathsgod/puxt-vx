<?php

namespace VX;

use VX\Authentication\UserInterface;

class Menu implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    /**
     * @var MenuItemInterface[]
     */
    public $items = [];

    public $groups = [];
    public $icons = [];

    public function addModule(Module $module)
    {
        if ($group = $module->getModuleGroup()) {
            $group->setTranslator($this->translator);
            if ($icon = $this->icons[$module->group]) {
                $group->setIcon($icon);
            }

            if (!in_array($group, $this->items)) {
                $this->items[] = $group;
            }

            $group->add($module);
        } else {
            $module->setTranslator($this->translator);
            $this->items[] = $module;
        }
    }




    public function setGroupIcon(array $icons)
    {
        $this->icons = $icons;
    }

    public function getMenuByUser(UserInterface $user)
    {
        $data = [];

        foreach ($this->getOrderedItems() as $item) {
            $menu = $item->getMenuItemByUser($user);
            if ($menu) {
                $data[] = $menu;
            }
        }

        return $data;
    }


    private function getOrderedItems()
    {
        $items = $this->items;
        usort($items, function ($a, $b) {
            return $a->sequence <=> $b->sequence;
        });

        return $items;
    }
}
