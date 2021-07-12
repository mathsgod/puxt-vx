<?php

namespace VX\UI;

use P\HTMLElement;
use VX\UI\EL\FormItem;

class TableSearch extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("vx-table-search");

        $this->template = new HTMLElement("template");
        $this->template->setAttribute("v-slot:default", "scope");
        $this->append($this->template);
    }

    public function addInput(string $label, string $prop)
    {
        $item = new FormItem;
        $item->setLabel($label);

        $input = $item->input($prop);
        $input->setAttribute("v-on:keyup.enter.native", 'table.search(scope.form)');
        $input->setAttribute("clearable", true);

        $this->template->append($item);
        return $input;
    }

    public function addDate(string $label, string $prop)
    {

        $item = new FormItem;
        $item->setLabel($label);

        $input = $item->datePicker($prop);
        $input->setAttribute("type","daterange");

        $this->template->append($item);
        return $input;
    }

    public function addSelect(string $label, string $prop)
    {
        $item = new FormItem;
        $item->setLabel($label);

        //$input = $item->input($prop);
        $input = $item->select($prop, [1 => "A", 2 => "B"]);
        $input->setAttribute("v-on:change", 'table.search(scope.form)');

        $this->template->append($item);
    }
}
