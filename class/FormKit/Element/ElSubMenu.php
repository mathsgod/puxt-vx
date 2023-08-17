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

        $this->attributes['popper-class'] = $value;
        return $this;
    }

    function showTimeout(int $value)
    {
        $this->attributes['show-timeout'] = $value;
        return $this;
    }

    function hideTimeout(int $value)
    {
        $this->attributes['hide-timeout'] = $value;
        return $this;
    }

    function disabled(bool $value = true)
    {
        $this->attributes['disabled'] = $value;
        return $this;
    }

    function teleported(bool $value = true)
    {
        $this->attributes['teleported'] = $value;
        return $this;
    }

    function popperOffset(int $value)
    {
        $this->attributes['popper-offset'] = $value;
        return $this;
    }

    function expandCloseIcon(string $value)
    {
        $this->attributes['expand-close-icon'] = $value;
        return $this;
    }

    function expandOpenIcon(string $value)
    {
        $this->attributes['expand-open-icon'] = $value;
        return $this;
    }

    function collapseCloseIcon(string $value)
    {
        $this->attributes['collapse-close-icon'] = $value;
        return $this;
    }

    function collapseOpenIcon(string $value)
    {
        $this->attributes['collapse-open-icon'] = $value;
        return $this;
    }
}
