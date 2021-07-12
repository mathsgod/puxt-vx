<?php

namespace VX\UI;

use P\HTMLElement;

class Table extends HTMLElement
{
    public $search;

    public function __construct()
    {
        parent::__construct("vx-table");

        $this->search = new TableSearch();
        $template = new HTMLElement("template");
        //$template->setAttribute("slot", "search");
        $template->setAttribute("v-slot:search", "table");
        $template->append($this->search);
        $this->append($template);
    }

    public function addView()
    {
        $column = new TableColumn;
        $column->setAttribute("width", "70");
        $template = new HTMLElement("template");
        $template->setAttribute("slot-scope", "props");
        $column->append($template);
        $this->append($column);
        $template->innerHTML = "<el-button icon='el-icon-search' type='primary' size='mini'></el-button>";

        return $template;
    }

    public function addEdit()
    {
        $column = new TableColumn;
        $column->setAttribute("width", "70");
        $template = new HTMLElement("template");
        $template->setAttribute("slot-scope", "props");
        $column->append($template);
        $this->append($column);
        $template->innerHTML = "<el-button icon='el-icon-edit' type='warning' size='mini'></el-button>";

        return $template;
    }

    public function addDel()
    {
        $column = new TableColumn;
        $column->setAttribute("width", "70");
        $template = new HTMLElement("template");
        $template->setAttribute("slot-scope", "props");
        $column->append($template);
        $this->append($column);
        $template->innerHTML = "<el-button icon='el-icon-close' type='danger' size='mini'></el-button>";

        return $template;
    }

    public function add(string $label, string $prop)
    {
        $column = new TableColumn;
        $this->append($column);

        $column->setLabel($label);
        $column->setProp($prop);

        return $column;
    }

    public function addExpand()
    {

        $column = new TableColumn;
        $column->setAttribute("type", "expand");

        $template = new HTMLElement("template");
        $template->setAttribute("slot-scope", "props");
        $column->append($template);

        $this->append($column);

        return $template;
    }
}
