<?php

namespace VX\UI\EL;

use P\HTMLElement;

class CheckboxGroup extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-checkbox-group");
    }

    function addCheckbox()
    {
        $checkbox = new Checkbox;
        $this->append($checkbox);
        return $checkbox;
    }
}
