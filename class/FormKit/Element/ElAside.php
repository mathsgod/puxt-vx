<?php

namespace FormKit\Element;

use FormKit\ComponentNode;

class ElAside extends ComponentNode
{

    function width(string $width)
    {
        $this->setAttribute('width', $width);
        return $this;
    }
}
