<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Tag extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-tag");
    }

    /**
     * success / info / warning / danger
     */
    function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }

    /**
     * medium / small / mini
     */
    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    /**
     * dark / light / plain
     */
    function setEffect(string $effect)
    {
        $this->setAttribute("effect", $effect);
    }
}
