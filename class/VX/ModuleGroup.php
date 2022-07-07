<?php

namespace VX;

class ModuleGroup implements TranslatorAwareInterface, MenuItemsInterface
{
    use TranslatorAwareTrait;

    public $name;

    /**
     * @var MenuItemsInterface[]
     */
    public $child = [];

    public $sequence = PHP_INT_MAX;

    public $icon = "far fa-circle";

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setIcon(string $icon)
    {
        $this->icon = $icon;
    }

    public function add(Module $module)
    {
        $this->child[] = $module;
        $module->setTranslator($this->translator);
        $this->sequence = min($this->sequence, $module->sequence);
    }

    public function getMenuItemByUser(User $user): array
    {
        $data = [];

        $data["label"] = $this->translator->trans($this->name);
        $data["icon"] = $this->icon;
        $data["link"] = "#";
        $data["seqeunce"] = $this->sequence;

        $submenu = [];
        foreach ($this->getOrderedChild() as $child) {
            $menu = $child->getMenuItemByUser($user);
            if ($menu) {
                $submenu[] = $menu;
            }
        }
        if (count($submenu) == 0) {
            return [];
        }


        $data["submenu"] = $submenu;

        return $data;
    }

    public function getOrderedChild()
    {
        $child = $this->child;
        usort($child, function ($a, $b) {
            return $a->sequence <=> $b->sequence;
        });
        return $child;
    }
}
