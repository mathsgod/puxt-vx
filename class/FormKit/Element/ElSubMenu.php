<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElSubMenu extends ComponentBaseNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElSubMenu', $property, $translator);
    }

    function addSubMenu()
    {
        $component = new ElSubMenu([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addMenuItem()
    {
        $item = new ElMenuItem([], $this->translator);
        $this->children[] = $item;
        return $item;
    }

    function addMenuItemGroup()
    {
        $component = new ElMenuItemGroup([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function index(string $value)
    {
        $this->props['index'] = $value;
        return $this;
    }

    function popperClass(string $value)
    {
        $this->props['popper-class'] = $value;
        return $this;
    }

    function showTimeout(int $value)
    {
        $this->props['show-timeout'] = $value;
        return $this;
    }

    function hideTimeout(int $value)
    {
        $this->props['hide-timeout'] = $value;
        return $this;
    }

    function disabled(bool $value = true)
    {
        $this->props['disabled'] = $value;
        return $this;
    }

    function teleported(bool $value = true)
    {
        $this->props['teleported'] = $value;
        return $this;
    }

    function popperOffset(int $value)
    {
        $this->props['popper-offset'] = $value;
        return $this;
    }

    function expandCloseIcon(string $value)
    {
        $this->props['expand-close-icon'] = $value;
        return $this;
    }

    function expandOpenIcon(string $value)
    {
        $this->props['expand-open-icon'] = $value;
        return $this;
    }

    function collapseCloseIcon(string $value)
    {
        $this->props['collapse-close-icon'] = $value;
        return $this;
    }

    function collapseOpenIcon(string $value)
    {
        $this->props['collapse-open-icon'] = $value;
        return $this;
    }
}
