<?php

namespace VX\UI;

use P\HTMLElement;
use VX\TranslatorAwareInterface;
use VX\TranslatorAwareTrait;

class TableColumn extends HTMLElement implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    const SEARCH_TYPE_TEXT = "text";
    const SEARCH_TYPE_DATE = "date";
    const SEARCH_TYPE_SELECT = "select";
    public $header;

    public function __construct()
    {
        parent::__construct("el-table-column");
    }

    public function template(callable $callback, string $scope = "scope")
    {
        $template = new HTMLElement("template");
        $template->setAttribute("v-slot", $scope);
        p($template)->html($callback());

        $this->append($template);

        return $this;
    }

    public function setLabel(string $label)
    {

        $this->setAttribute("label", $this->translator ? $this->translator->trans($label) : $label);
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

    public function width(string $width)
    {
        $this->setAttribute("width", $width);
        return $this;
    }

    public function filterable(array $value)
    {
        $this->setAttribute(":filters", json_encode($value));

        $prop = $this->getAttribute("prop");
        $this->setAttribute("column-key", $prop);

        return $this;
    }

    public function overflow()
    {
        $this->setAttribute(":show-overflow-tooltip", "true");
        return $this;
    }

    public function searchable(string $type = TableColumn::SEARCH_TYPE_TEXT)
    {
        $node = $this->closest("vx-table");
        if ($node instanceof Table) {
            $node->setAttribute("searchable", true);

            match ($type) {
                self::SEARCH_TYPE_TEXT => $node->search->addInput($this->getAttribute("label"), $this->getAttribute("prop")),
                self::SEARCH_TYPE_DATE => $node->search->addDate($this->getAttribute("label"), $this->getAttribute("prop")),
                self::SEARCH_TYPE_SELECT => $node->search->addSelect($this->getAttribute("label"), $this->getAttribute("prop"))
            };
        }

        /*
        search input in column
        if (!$this->header) {
            $this->header = new TableColumnHeader;
            $this->header->setLabel($this->getAttribute("label"));

            $this->append($this->header);
            $this->setAttribute("label-class-name", "d-flex align-items-center");

            $input = $this->header->addInput();

            $prop = $this->getAttribute("prop");

            $input->setAttribute("v-model", 'table.search.' . $prop);
            //$input->setAttribute("v-on:keyup.enter.native", '');
            //$input->setAttribute("v-on:clear", "table.onSearch");
            $input->setAttribute("clearable", true);
        }
*/

        return $this;
    }

    public function fixed()
    {
        $this->setAttribute(":fixed", "true");
        return $this;
    }

    public function nowrap()
    {
        //$this->setAttribute(':cell-style', json_encode(["white-space" => "nowrap"]));

        return $this;
    }
}
