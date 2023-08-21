<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QBtn extends ComponentNode
{

    public function to(string $to)
    {
        $this->setAttribute("to", $to);
        return $this;
    }

    public function round()
    {
        $this->setAttribute("round", true);
        return $this;
    }

    public function rounded()
    {
        $this->setAttribute("rounded", true);
        return $this;
    }

    public function icon(string $icon)
    {
        $this->setAttribute("icon", $icon);
        return $this;
    }

    public function color(string $color)
    {
        $this->setAttribute("color", $color);
        return $this;
    }

    public function outline()
    {
        $this->setAttribute("outline", true);
        return $this;
    }
}
