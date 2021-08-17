<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Button extends HTMLElement
{
    const SIZE_MINI = "mini";
    const SIZE_SMALL = "small";
    const SIZE_MEDIUM = "medium";
    const SIZE_LARGE = "large";

    public function __construct()
    {
        parent::__construct("el-button");
    }

    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }
}
