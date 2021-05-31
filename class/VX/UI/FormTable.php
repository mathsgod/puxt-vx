<?php

namespace VX\UI;

use P\HTMLElement;

class FormTable extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("vx-form-table");
    }

    public function add(string $label, string $prop = null)
    {
        
        $column = new FormTableColumn();
        $column->setAttribute("label", $label);
        if ($prop !== null) {
            $column->setAttribute("prop", $prop);
        }
        $this->append($column);
        return $column;
    }
}
