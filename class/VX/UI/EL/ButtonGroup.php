<?php

namespace VX\UI\EL;

use P\HTMLElement;

class ButtonGroup extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-button-group");
    }

    function addButton()
    {
        $this->append($button = new Button());
        return $button;
    }
}
