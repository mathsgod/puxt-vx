<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Table extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("el-table");
    }

    public function setData(array $data)
    {
        $this->setAttribute(":data", json_encode($data));
        return $this;
    }

    public function addColumn(?string $label, ?string $prop)
    {
        $column = new TableColumn;
        $this->append($column);
        if ($label) {
            $column->setLabel($label);
        }

        if ($prop) {
            $column->setProp($prop);
        }

        return $column;
    }

    public function stripe()
    {
        $this->setAttribute(":strip", "true");
        return $this;
    }

    public function border()
    {
        $this->setAttribute(":border", "true");
        return $this;
    }

    
}
