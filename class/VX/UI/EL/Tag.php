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
     * component type
     * @param string $type success / info / warning / danger
     */
    function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }

    /**
     * whether Tag can be removed
     */
    function setClosable(bool $closable)
    {
        $this->setAttribute("closable", $closable);
    }

    /**
     * whether to disable animations
     */
    function setDisableTransitions(bool $disable)
    {
        $this->setAttribute("disable-transitions", $disable);
    }

    /**
     * whether Tag has a highlighted border
     */
    function setHit(bool $hit)
    {
        $this->setAttribute("hit", $hit);
    }

    /**
     * background color of the Tag
     */
    function setColor(string $color)
    {
        $this->setAttribute("color", $color);
    }

    /**
     * tag size
     * @param string $size medium / small / mini
     */
    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    /**
     * component theme
     * @param string $effect dark / light / plain
     */
    function setEffect(string $effect)
    {
        $this->setAttribute("effect", $effect);
    }
}
