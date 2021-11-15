<?php

namespace VX\UI;

use Closure;
use P\HTMLElement;
use P\HTMLTemplateElement;
use P\MutationObserver;
use VX;
use VX\TranslatorAwareInterface;
use VX\TranslatorAwareTrait;

class Table extends HTMLElement implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    const SIZE_SMALL = "small";
    const SIZE_MINI = "mini";
    const SIZE_MEDIUM = "medium";
    const SIZE_LARGE = "large";

    const SORT_ORDER_DESC = "descending";
    const SORT_ORDER_ASC = "ascending";

    public $search;
    public $default;

    public $body;
    public $vx;
    public function __construct()
    {
        parent::__construct("vx-table");

        $this->search = new TableSearch();
        $this->search->setAttribute("v-slot:search", "table");
        $this->append($this->search);

        $this->default = new HTMLElement("template");
        $this->default->setAttribute("v-slot", "table");
        $this->append($this->default);

        $observer = new MutationObserver(function ($records) {
            $this->generateMetadata();
        });

        $observer->observe($this, [
            "childList" => true,
            "subtree" => true
        ]);
    }

    function setVX(VX $vx)
    {
        $this->vx = $vx;
    }

    function setHeader(string $header)
    {
        $this->setAttribute("header", $header);
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


    /**
     * @param string $order desc | asc
     */
    public function setDefaultSort(string $prop, string $order)
    {
        if ($order == "desc") {
            $order = "descending";
        }
        if ($order == "asc") {
            $order = "ascending";
        }

        $this->setAttribute(":default-sort", json_encode(["prop" => $prop, "order" => $order]));
    }

    /**
     * @param string $size small / mini / medium / large
     */
    public function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    public function addActionColumn()
    {
        $this->setAttribute("show-view", true);
        $this->setAttribute("show-update", true);
        $this->setAttribute("show-delete", true);

        $this->default->appendChild($column = new TableActionColumn);
        $column->setAttribute("v-slot:default", "props");
        $column->setTranslator($this->translator);

        $column->setAttribute("width", "115");
        $column->setAttribute("min-width", "115");

        return $column;
    }

    /**
     * @deprecated Use addActionColumn
     */
    public function addView()
    {
        $this->setAttribute("show-view", true);

        $column = new TableColumn;
        $column->setTranslator($this->translator);
        $column->setAttribute("width", "70");
        $template = new HTMLElement("template");
        $template->setAttribute("slot-scope", "props");
        $column->append($template);
        $this->default->append($column);
        $template->innerHTML = "<el-button v-if='props.row.__view__' icon='el-icon-search' type='primary' size='mini' v-on:click='\$router.push(props.row.__view__.value)'></el-button>";
        return $template;
    }

    /**
     * @deprecated Use addActionColumn
     */
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

    /**
     * @deprecated Use addActionColumn
     */
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

    /**
     * @param null|string|callable $prop
     */
    public function add(string $label, $prop = null)
    {
        $column = new TableColumn;
        $column->setTranslator($this->translator);

        $column->setLabel($label);

        if ($prop) {
            $column->setProp($prop);
        }

        $this->default->appendChild($column);

        return $column;
    }


    public function addExpand(string $label = "", ?callable $callback, string $scope = "scope")
    {

        $column = new TableColumn;
        $column->setAttribute("type", "expand");
        $column->setAttribute("label", $label);

        $this->default->append($column);

        if ($callback instanceof Closure) {
            $template = new HTMLTemplateElement;
            $template->setAttribute("v-slot:default", $scope);
            $column->appendChild($template);
            $callback($template);
            return;
        }

        $template = new HTMLElement("template");
        $template->setAttribute("v-slot:default", "props");
        $column->append($template);


        return $template;
    }

    private function generateMetadata()
    {
        //generate metadata
        $metadata = [];
        foreach ($this->default->children as $child) {

            if ($child instanceof TableActionColumn) {
                $metadata["columns"][] = [
                    "prop" => "__view__"
                ];

                $metadata["columns"][] = [
                    "prop" => "__update__"
                ];

                $metadata["columns"][] = [
                    "prop" => "__delete__"
                ];
                continue;
            }


            $metadata["columns"][] = [
                "prop" => $child->getAttribute("prop") ?? "",
                "sortable" => $child->hasAttribute("sortable")
            ];
        }



        $this->setAttribute("metadata", $this->vx->generateToken($this->vx->user, $metadata));
    }
}
