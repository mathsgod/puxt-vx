<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Badge extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-badge");
    }

    /**
     * display value
     */
    function setValue(string|int $value)
    {
        if (is_string($value)) {
            $this->setAttribute("value", $value);
        } else {
            $this->setAttribute(":value", $value);
        }
    }

    /**
     * maximum value, shows '{max}+' when exceeded. Only works if value is a Number
     */
    function setMax(int $max)
    {
        $this->setAttribute(":max", $max);
    }

    /**
     * if a little dot is displayed
     */
    function setIsDot(bool $is_dot)
    {
        $this->setAttribute("is-dot", $is_dot);
    }

    /**
     * hidden badge
     */
    function setHidden(bool $hidden)
    {
        $this->setAttribute("hidden", $hidden);
    }

    /**
     * button type
     * @param string $type primary / success / warning / danger / info
     */
    function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }
}
