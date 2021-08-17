<?php

namespace VX\UI\EL;

use P\HTMLElement;
use P\HTMLTemplateElement;

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

    function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }


    public function addTemplate(callable $callback, string $scope = "scope")
    {
        $template = new HTMLTemplateElement();
        $template->setAttribute("v-slot", $scope);
        $callback($template);

        $this->append($template);

        return $this;
    }
}
