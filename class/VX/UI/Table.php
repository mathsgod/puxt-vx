<?php

namespace VX\UI;

use P\HTMLElement;

class Table extends HTMLElement
{

    const SIZE_SMALL = "small";
    const SIZE_MINI = "mini";
    const SIZE_MEDIUM = "medium";
    const SIZE_LARGE = "large";

    const SORT_ORDER_DESC = "descending";
    const SORT_ORDER_ASC = "ascending";

    public $search;

    public $body;
    public function __construct()
    {
        parent::__construct("vx-table");

        $this->search = new TableSearch();
        $this->search->setAttribute("v-slot:search", "table");
        $this->append($this->search);

        $this->default = new HTMLElement("template");
        $this->default->setAttribute("v-slot", "table");
        $this->append($this->default);
    }

    public function setPagination(bool $pagination)
    {
        $this->setAttribute(":pagination", $pagination ? "true" : "false");
    }

    public function setBorder(bool $border)
    {
        if ($border) {
            $this->setAttribute("border", true);
        } else {
            $this->removeAttribute("border");
        }
    }

    public function setDefaultSort(string $prop, string $order)
    {
        $this->setAttribute(":default-sort", json_encode(["prop" => $prop, "order" => $order]));
    }

    public function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    public function addView()
    {
        $this->setAttribute("show-view", true);

        $column = new TableColumn;
        $column->setAttribute("width", "70");
        $template = new HTMLElement("template");
        $template->setAttribute("slot-scope", "props");
        $column->append($template);
        $this->default->append($column);
        $template->innerHTML = "<el-button v-if='props.row.__view__' icon='el-icon-search' type='primary' size='mini' v-on:click='\$router.push(props.row.__view__.value)'></el-button>";
        return $template;
    }

    public function addEdit()
    {
        $this->setAttribute("show-update", true);

        $column = new TableColumn;
        $column->setAttribute("width", "70");
        $template = new HTMLElement("template");
        $template->setAttribute("v-slot:default", "props");


        $column->append($template);
        $this->default->append($column);
        $template->innerHTML = "<el-button v-if='props.row.__update__' icon='el-icon-edit' type='warning' size='mini' v-on:click='\$router.push(props.row.__update__.value)'></el-button>";

        return $template;
    }

    public function addDel()
    {
        $this->setAttribute("show-delete", true);
        $column = new TableColumn;
        $column->setAttribute("width", "70");
        $template = new HTMLElement("template");
        $template->setAttribute("v-slot:default", "props");
        $column->append($template);
        $this->default->append($column);
        $template->innerHTML = "<el-button v-if='props.row.__delete__' icon='el-icon-close' type='danger' size='mini' v-on:click='table.delete(props.row.__delete__.value)'></el-button>";

        return $template;
    }

    public function add(string $label, ?string $prop = null)
    {
        $column = new TableColumn;
        $this->default->append($column);

        $column->setLabel($label);

        if ($prop) {
            $column->setProp($prop);
        }


        return $column;
    }

    public function addExpand(string $label = "")
    {

        $column = new TableColumn;
        $column->setAttribute("type", "expand");
        $column->setAttribute("label", $label);

        $template = new HTMLElement("template");
        $template->setAttribute("v-slot:default", "props");
        $column->append($template);

        $this->default->append($column);

        return $template;
    }
}
