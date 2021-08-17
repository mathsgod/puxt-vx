<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Upload extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("el-upload");
    }

    public function setMultiple(bool $multiple)
    {
        $this->setAttribute("multiple", $multiple);
    }
}
