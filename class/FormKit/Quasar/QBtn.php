<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QBtn extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('QBtn', $property, $translator);
    }

    public function to(string $to)
    {
        return $this->setProp("to", $to);
    }

    public function round()
    {
        return $this->setProp("round", true);
    }

    public function rounded()
    {
        return $this->setProp("rounded", true);
    }

    public function icon(string $icon)
    {
        return $this->setProp("icon", $icon);
    }

    public function color(string $color)
    {
        return $this->setProp("color", $color);
    }

    public function outline()
    {
        return $this->setProp("outline", true);
    }
}
