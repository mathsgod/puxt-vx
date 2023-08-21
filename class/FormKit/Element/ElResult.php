<?php

namespace FormKit\Element;

use FormKit\ComponentNode;

class ElResult extends ComponentNode
{

    /**
     * title
     */
    function title(string $value)
    {
        $this->setAttribute('title', $value);
        return $this;
    }

    /**
     * subtitle
     */
    function subTitle(string $value)
    {
        $this->setAttribute('sub-title', $value);
        return $this;
    }

    /**
     * icon
     */
    function icon(string $value)
    {
        $this->setAttribute('icon', $value);
        return $this;
    }
}
