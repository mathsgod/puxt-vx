<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElMenu extends ComponentBaseNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("ElMenu", $property, $translator);
    }

    public function addMenuItem()
    {
        $item = new ElMenuItem([], $this->translator);
        $this->children[] = $item;
        return $item;
    }

    public function item(string $label, ?string $index)
    {
        $item = $this->addMenuItem();
        $item->addChildren($label);
        if ($index) {
            $item->index($index);
        }
        return $this;
    }

    public function mode(string $mode)
    {
        $this->setProp('mode', $mode);
        return $this;
    }

    public function collapse(bool $collapse)
    {
        $this->setProp('collapse', $collapse);
        return $this;
    }

    public function backgroundColor(string $backgroundColor)
    {
        $this->setProp('background-color', $backgroundColor);
        return $this;
    }

    public function textColor(string $textColor)
    {
        $this->setProp('text-color', $textColor);
        return $this;
    }

    public function activeTextColor(string $activeTextColor)
    {
        $this->setProp('active-text-color', $activeTextColor);
        return $this;
    }

    public function defaultActive(string $defaultActive)
    {
        $this->setProp('default-active', $defaultActive);
        return $this;
    }

    public function defaultOpeneds(array $defaultOpeneds)
    {
        $this->setProp('default-openeds', $defaultOpeneds);
        return $this;
    }

    public function uniqueOpened(bool $uniqueOpened)
    {
        $this->setProp('unique-opened', $uniqueOpened);
        return $this;
    }

    public function menuTrigger(string $menuTrigger)
    {
        $this->setProp('menu-trigger', $menuTrigger);
        return $this;
    }

    public function router(bool $router = true)
    {
        $this->setProp('router', $router);
        return $this;
    }
}
