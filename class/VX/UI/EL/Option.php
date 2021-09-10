<?php

namespace VX\UI\EL;

use P\Element;

class Option extends Element
{
    public function __construct()
    {
        parent::__construct("el-option");
    }

    public function setValue($value)
    {
        $this->setAttribute(":value", json_encode($value));
    }

    public function setLabel(string|int $label)
    {
        $this->setAttribute(":label", json_encode($label));
    }
}
