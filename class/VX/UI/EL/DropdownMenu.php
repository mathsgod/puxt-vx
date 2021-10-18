<?php

namespace VX\UI\EL;

use P\HTMLElement;

class DropdownMenu extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-dropdown-menu");
    }

    function addItem()
    {
        $ddi = new DropdownItem;
        $this->append($ddi);
        return $ddi;
    }
}
