<?php

namespace VX\UI;

use P\HTMLElement;

class TableColumn extends HTMLElement
{

    const SEARCH_TYPE_TEXT = "text";
    const SEARCH_TYPE_DATE = "date";
    const SEARCH_TYPE_SELECT = "select";

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

    public function filterable(array $value)
    {
        $this->setAttribute(":filters", json_encode($value));

        $prop = $this->getAttribute("prop");
        $this->setAttribute("column-key", $prop);

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
        
        return $this;
    }
}
