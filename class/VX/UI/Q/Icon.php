<?php

namespace VX\UI\Q;

use P\HTMLElement;

class Icon extends HTMLElement
{

    public function __construct()
    {
        parent::__construct("q-icon");
    }

    public function setName(string $name)
    {
        $this->setAttribute("name", $name);
    }

    public function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }
}
