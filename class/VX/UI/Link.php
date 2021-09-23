<?php

namespace VX\UI;

use P\HTMLElement;

class Link extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("router-link");
    }

    public function setTo(string $to)
    {
        $this->setAttribute("to", $to);
    }
}
