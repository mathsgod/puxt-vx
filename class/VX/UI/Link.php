<?php

namespace VX\UI;

use P\HTMLElement;

class Link extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("route-link");
    }
}