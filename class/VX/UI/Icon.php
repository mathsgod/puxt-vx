<?php

namespace VX\UI;

use P\HTMLElement;

class Icon extends HTMLElement
{

    public function __construct()
    {
        parent::__construct("vx-icon");
    }

    public function setName(string $name)
    {
        $this->setAttribute("name", $name);
    }

    public function setWidth(string $width){
        $this->setAttribute("width",$width);
    }
}
