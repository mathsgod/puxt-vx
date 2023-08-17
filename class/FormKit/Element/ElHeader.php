<?php

namespace FormKit\Element;

use FormKit\ComponentNode;

class ElHeader extends ComponentNode
{
    function height(string $height)
    {
        $this->setAttribute('height', $height);
        return $this;
    }
}
