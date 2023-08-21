<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElSubMenu extends ComponentBaseNode
{

    function addSubMenu(): ElSubMenu
    {
        return $this->appendHTML('<el-sub-menu></el-sub-menu>')[0];
    }

    function addMenuItem(): ElMenuItem
    {
        return $this->appendHTML('<el-menu-item></el-menu-item>')[0];
    }

    function addMenuItemGroup(): ElMenuItemGroup
    {
        return $this->appendHTML('<el-menu-item-group></el-menu-item-group>')[0];
    }

    function index(string $value)
    {
        $this->setAttribute('index', $value);
    }

    function popperClass(string $value)
    {

        $this->setAttribute('popper-class', $value);
        return $this;
    }

    function showTimeout(int $value)
    {
        $this->setAttribute('show-timeout', $value);
        return $this;
    }

    function hideTimeout(int $value)
    {
        $this->setAttribute('hide-timeout', $value);
        return $this;
    }

    function disabled(bool $value = true)
    {
        $this->setAttribute('disabled', $value);
        return $this;
    }

    function teleported(bool $value = true)
    {
        $this->setAttribute('teleported', $value);
        return $this;
    }

    function popperOffset(int $value)
    {
        $this->setAttribute('popper-offset', $value);
        return $this;
    }

    function expandCloseIcon(string $value)
    {
        $this->setAttribute('expand-close-icon', $value);
        return $this;
    }

    function expandOpenIcon(string $value)
    {
        $this->setAttribute('expand-open-icon', $value);
        return $this;
    }

    function collapseCloseIcon(string $value)
    {
        $this->setAttribute('collapse-close-icon', $value);
        return $this;
    }

    function collapseOpenIcon(string $value)
    {
        $this->setAttribute('collapse-open-icon', $value);
        return $this;
    }
}
