<?php

namespace VX\UI\EL;

use P\Element;

class Option extends Element
{
    function __construct()
    {
        parent::__construct("el-option");
    }

    /**
     * value of option
     */
    function setValue(string|int|array $value)
    {
        if (is_string($value)) {
            $this->setAttribute("value", $value);
        } elseif (is_array($value)) {
            $this->setAttribute(":value", json_encode($value, JSON_UNESCAPED_UNICODE));
        } else {
            $this->setAttribute(":value", $value);
        }
    }

    /**
     * label of option, same as value if omitted
     */
    function setLabel(string|int $label)
    {
        if (is_string($label)) {
            $this->setAttribute("label", $label);
        } else {
            $this->setAttribute(":label", $label);
        }
    }
}
