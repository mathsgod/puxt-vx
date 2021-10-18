<?php

namespace VX\UI\EL;

use P\HTMLElement;

class CollapseItem extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-collapse-item");
    }

    /**
     * unique identification of the panel
     */
    function setName(string|int $name)
    {
        if (is_string($name)) {
            $this->setAttribute("name", $name);
        } else {
            $this->setAttribute(":name", $name);
        }
    }

    /**
     * title of the panel
     */
    function setTitle(string $title)
    {
        $this->setAttribute("title", $title);
    }

    /**
     * disable the collapse item
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }
}
