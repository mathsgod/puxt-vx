<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Divider extends HTMLElement
{

    public function __construct()
    {
        parent::__construct("el-divider");
    }

    public function setDirection(string $direction)
    {
        $this->setAttribute("direction", $direction);
    }

    public function setContentPosition(string $position)
    {
        $this->setAttribute("content-position", $position);
    }
}
