<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Collapse extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-collapse");
    }

    function setAccordion(bool $accordion)
    {
        $this->setAttribute("accordion", $accordion);
    }

    function addItem()
    {
        $item = new CollapseItem;
        $this->append($item);
        return $item;
    }
}
