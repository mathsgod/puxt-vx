<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElMenu extends ComponentBaseNode
{

    function addSubMenu(): ElSubMenu
    {
        return $this->appendHTML('<el-sub-menu></el-sub-menu>')[0];
    }

    function addMenuItem(): ElMenuItem
    {
        return $this->appendHTML('<el-menu-item></el-menu-item>')[0];
    }

    public function item(string $label, ?string $index)
    {
        $item = $this->addMenuItem();
        $item->append($label);
        if ($index) {
            $item->index($index);
        }
        return $this;
    }

    public function mode(string $mode)
    {
        $this->setAttribute('mode', $mode);
        return $this;
    }

    public function collapse(bool $collapse)
    {
        $this->setAttribute('collapse', $collapse);
        return $this;
    }

    public function backgroundColor(string $backgroundColor)
    {
        $this->setAttribute('background-color', $backgroundColor);
        return $this;
    }

    public function textColor(string $textColor)
    {
        $this->setAttribute('text-color', $textColor);
        return $this;
    }

    public function activeTextColor(string $activeTextColor)
    {
        $this->setAttribute('active-text-color', $activeTextColor);
        return $this;
    }

    public function defaultActive(string $defaultActive)
    {
        $this->setAttribute('default-active', $defaultActive);
        return $this;
    }

    public function defaultOpeneds(array $defaultOpeneds)
    {
        $this->setAttribute('default-openeds', $defaultOpeneds);
        return $this;
    }

    public function uniqueOpened(bool $uniqueOpened)
    {
        $this->setAttribute('unique-opened', $uniqueOpened);
        return $this;
    }

    public function menuTrigger(string $menuTrigger)
    {
        $this->setAttribute('menu-trigger', $menuTrigger);
        return $this;
    }

    public function router(bool $router = true)
    {
        $this->setAttribute('router', $router);
        return $this;
    }
}
