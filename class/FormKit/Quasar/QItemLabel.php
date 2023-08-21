<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QItemLabel extends ComponentNode
{
    public function caption(bool $bool = true)
    {
        $this->setAttribute("caption", $bool);
        return $this;
    }

    public function lines(int $lines)
    {
        $this->setAttribute("lines", $lines);
        return $this;
    }
}
