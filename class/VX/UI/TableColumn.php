<?php

namespace VX\UI;

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
        $this->setAttribute("sortable", "custom");
        return $this;
    }

    public function searchable(string $type = "text")
    {
        $node = $this->closest("vx-table");
        if ($node instanceof Table) {
            if ($type == "text") {
                $node->search->addInput($this->getAttribute("label"), $this->getAttribute("prop"));
            } elseif ($type == "date") {
                $node->search->addDate($this->getAttribute("label"), $this->getAttribute("prop"));
            }
        }


        return $this;
    }
}
