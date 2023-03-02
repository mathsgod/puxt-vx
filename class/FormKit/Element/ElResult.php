<?php

namespace FormKit\Element;

use FormKit\ComponentNode;

class ElResult extends ComponentNode
{
    public function __construct()
    {
        parent::__construct('ElResult');
    }

    /**
     * title
     */
    function title(string $value)
    {
        $this->props['title'] = $value;
        return $this;
    }

    /**
     * subtitle
     */
    function subTitle(string $value)
    {
        $this->props['sub-title'] = $value;
        return $this;
    }

    /**
     * icon
     */
    function icon(string $value)
    {
        $this->props['icon'] = $value;
        return $this;
    }
}
