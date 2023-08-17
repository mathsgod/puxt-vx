<?php

namespace FormKit\Element;

use FormKit\ComponentNode;

class ElAffix extends ComponentNode
{

    function offset(int $value)
    {
        $this->setAttribute('offset', $value);
        return $this;
    }

    /**
     * position of affix.
     */
    function position(string $value)
    {
        $this->setAttribute('position', $value);
        return $this;
    }

    /**
     * 	target container. (CSS selector)
     */
    function target(string $value)
    {
        $this->setAttribute('target', $value);
        return $this;
    }

    function zIndex(int $value)
    {
        $this->setAttribute('zIndex', $value);
        return $this;
    }
}
