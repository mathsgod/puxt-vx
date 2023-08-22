<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QCardActions extends ComponentNode
{
    public function align(string $align)
    {
        $this->setAttribute("align", $align);
        return $this;
    }

    public function vertical(bool $vertical = true)
    {
        $this->setAttribute("vertical", $vertical);
        return $this;
    }
}
