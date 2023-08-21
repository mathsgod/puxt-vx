<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QBtn extends ComponentNode
{

    public function to(string $to)
    {
        return $this->setAttribute("to", $to);
    }

    public function round()
    {
        return $this->setAttribute("round", true);
    }

    public function rounded()
    {
        return $this->setAttribute("rounded", true);
    }

    public function icon(string $icon)
    {
        return $this->setAttribute("icon", $icon);
    }

    public function color(string $color)
    {
        return $this->setAttribute("color", $color);
    }

    public function outline()
    {
        return $this->setAttribute("outline", true);
    }
}
