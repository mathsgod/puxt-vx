<?php

namespace VX;

use Symfony\Contracts\Translation\TranslatorInterface;
use VX\Security\UserInterface;

class ModuleGroup implements MenuItemInterface
{


    public $name;

    /**
     * @var MenuItemInterface[]
     */
    public $child = [];

    public $sequence = PHP_INT_MAX;

    public $icon = "far fa-circle";

    private static $Instances = [];

    protected $translator;

    /**
     * Create a new ModuleGroup if not exists.
     */
    public static function Get(string $name, TranslatorInterface $translator): self
    {
        if (!isset(self::$Instances[$name])) {
            self::$Instances[$name] = new self($name, $translator);
        }
        return self::$Instances[$name];
    }

    public function __construct(string $name, TranslatorInterface $translator)
    {
        $this->name = $name;
        $this->translator = $translator;
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
