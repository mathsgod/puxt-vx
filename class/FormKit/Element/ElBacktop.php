<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElBacktop extends ComponentNode
{

    function target(string $value)
    {
        $this->setAttribute('target', $value);
        return $this;
    }

    function visibilityHeight(int $value)
    {
        $this->setAttribute('visibility-height', $value);
        return $this;
    }

    function right(int $value)
    {
        $this->setAttribute('right', $value);
        return $this;
    }

    function bottom(int $value)
    {
        $this->setAttribute('bottom', $value);
        return $this;
    }
}
