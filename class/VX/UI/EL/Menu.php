<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Menu extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-menu");
    }

    /**
     * menu display mode
     * @param string $mode 	horizontal / vertical
     */
    function setMode(string $mode)
    {
        $this->setAttribute("mode", $mode);
    }

    function addItem()
    {
        $item = new MenuItem;
        $this->append($item);
        return $item;
    }
}
