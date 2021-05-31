<?php

namespace VX\UI;

use P\HTMLElement;

class FormTableInput extends HTMLElement
{

    public function __construct()
    {
        parent::__construct("el-input");
    }

    public function required()
    {
        $this->setAttribute("required", true);
        return;
    }
}
