<?php

namespace VX\UI;

use P\HTMLElement;
use P\HTMLTemplateElement;

class Dialog extends HTMLElement
{
    function __construct()
    {
        parent::__construct("vx-dialog");
    }

    function activiator(callable $callback)
    {
        $template = new HTMLTemplateElement;
        $template->setAttribute("v-slot:activator", "{on}");
        $this->append($template);
        $callback($template);
        return $this;
    }

    function setWidth(string $width)
    {
        $this->setAttribute("width", $width);
    }

    function setTitle(string $title)
    {
        $this->setAttribute("title", $title);
    }
}
