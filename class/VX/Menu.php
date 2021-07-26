<?php

namespace VX;


class Menu implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    public $items = [];
    public $groups = [];
    public function addModule(Module $module)
    {
        if ($module->group) {
            if (!$mg = $this->groups[$module->group]) {
                $mg = new ModuleGroup($module->group);
                $mg->setTranslator($this->translator);
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
