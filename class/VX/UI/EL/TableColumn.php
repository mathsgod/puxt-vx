<?php

namespace VX\UI\EL;

use P\HTMLElement;

class TableColumn extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("el-table-column");
    }

    public function setLabel(string $label)
    {
        $this->setAttribute("label", $label);
        return $this;
    }

    public function setProp(string $prop)
    {
        $this->setAttribute("prop", $prop);
        return $this;
    }

    public function sortable()
    {
        $this->setAttribute("sortable", true);
        return $this;
    }

    public function width(string $width)
    {
        $this->setWidth($width);
        return $this;
    }

    public function setWidth(string $width)
    {
        $this->setAttribute("width", $width);
    }
}
