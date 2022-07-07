<?php

namespace VX;

use Laminas\Permissions\Acl\AclInterface;

class Menu implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    /**
     * @var MenuItemInterface[]
     */
    public $items = [];
    public $groups = [];
    public $icons = [];
    public $acl;
    public function addModule(Module $module)
    {
        $module->setAcl($this->acl);
        if ($module->group) {
            if (!$mg = $this->groups[$module->group]) {
                $mg = new ModuleGroup($module->group);

                if ($icon = $this->icons[$module->group]) {
                    $mg->setIcon($icon);
                }

                $mg->setTranslator($this->translator);
                $this->groups[$module->group] = $mg;
                $this->items[] = $mg;
            }
            $mg->add($module);
        } else {
            $module->setTranslator($this->translator);
            $this->items[] = $module;
        }
    }

    public function setACL(AclInterface $acl)
    {;
        $this->acl = $acl;
    }

    public function setGroupIcon(array $icons)
    {
        $this->icons = $icons;
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
