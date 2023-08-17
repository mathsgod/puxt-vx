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
        $this->attributes['title'] = $value;
        return $this;
    }

    /**
     * subtitle
     */
    function subTitle(string $value)
    {
        $this->attributes['sub-title'] = $value;
        return $this;
    }

    /**
     * icon
     */
    function icon(string $value)
    {
        $this->attributes['icon'] = $value;
        return $this;
    }
}
