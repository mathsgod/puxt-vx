<?php

namespace VX\UI\EL;

class Input extends FormItemElement
{
    public function __construct()
    {
        parent::__construct("el-input");
    }

    public function placeholder(string $placeholder)
    {
        $this->setAttribute("placeholder", $placeholder);
        return $this;
    }
}
