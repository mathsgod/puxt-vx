<?php

namespace VX;

use VX\Authentication\UserInterface;

class ModuleGroup implements TranslatorAwareInterface, MenuItemInterface
{
    use TranslatorAwareTrait;

    public $name;

    /**
     * @var MenuItemInterface[]
     */
    public $child = [];

    public $sequence = PHP_INT_MAX;

    public $icon = "far fa-circle";


    private static $Instances = [];

    /**
     * Create a new ModuleGroup if not exists.
     */
    public static function Get(string $name): self
    {
        if (!isset(self::$Instances[$name])) {
            self::$Instances[$name] = new self($name);
        }
        return self::$Instances[$name];
    }

    public function __construct(string $name)
    {
        $this->name = $name;
    }


    public function setIcon(string $icon)
    {
        $this->icon = $icon;
    }

    public function getLabel(): string
    {
        return $this->name;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getLink(): ?string
    {
        return null;
    }

    public function add(Module $module)
    {
        $this->child[] = $module;
        $module->setTranslator($this->translator);
        $this->sequence = min($this->sequence, $module->sequence);
    }

    public function getMenuItemByUser(UserInterface $user): array
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


        $data["menus"] = $submenu;

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
