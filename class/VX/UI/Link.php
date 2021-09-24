<?php

namespace VX\UI;

use P\HTMLElement;

class Link extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("el-link");
    }

    public function setHref(string $href)
    {
        $this->setAttribute("href", $href);
    }
}
