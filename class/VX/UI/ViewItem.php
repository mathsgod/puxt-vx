<?php

namespace VX\UI;

use P\HTMLElement;

class ViewItem extends HTMLElement
{

    public function __construct()
    {
        parent::__construct("vx-view-item");
    }

    public function setLabel(string $label)
    {
        $this->setAttribute("label", $label);
        return $this;
    }

    public function setContent(string $content)
    {
        $this->innerHTML = $content;
        return $this;
    }
}
