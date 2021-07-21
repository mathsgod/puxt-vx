<?php

namespace VX\UI;

use P\HTMLElement;
use VX\UI\EL\Input;

class TableColumnHeader extends HTMLElement
{
    public $content;
    public function __construct()
    {
        parent::__construct("template");
        $this->setAttribute("v-slot:header", "scope");
        $content = new HTMLElement("div");

        $content->classList->add("d-flex", "flex-column");
        $this->content = $content;
        $this->append($this->content);
    }

    public function setLabel(string $label)
    {
        $this->content->append($label);
    }

    public function addInput()
    {
        $input = new Input;
        $this->content->append($input);
        $input->setAttribute("v-on:click.native.stop", true);

        return $input;
    }
}
