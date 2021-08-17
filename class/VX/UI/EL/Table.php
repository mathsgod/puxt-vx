<?php

namespace VX\UI\EL;

use P\HTMLElement;
use Traversable;

class Table extends HTMLElement
{
    const SIZE_MINI = "mini";
    const SIZE_SMALL = "small";
    const SIZE_MEDIUM = "medium";
    const SIZE_LARGE = "large";

    public function __construct()
    {
        parent::__construct("el-table");
    }

    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }


    public function setData(array|Traversable $data)
    {
        if ($data instanceof Traversable) {
            $data = iterator_to_array($data);
        }
        $this->setAttribute(":data", json_encode($data));
        return $this;
    }

    public function addColumn(?string $label = null, ?string $prop = null)
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
