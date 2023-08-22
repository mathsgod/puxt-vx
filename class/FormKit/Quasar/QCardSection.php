<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QCardSection extends ComponentNode
{
    public function horizontal(bool $horizontal = true)
    {
        $this->setAttribute("horizontal", true);
        return $this;
    }

    public function tag(string $tag)
    {
        $this->setAttribute("tag", $tag);
        return $this;
    }
}
