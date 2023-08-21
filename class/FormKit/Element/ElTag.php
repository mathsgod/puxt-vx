<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElTag extends ComponentNode
{
    

    /**
     * success/info/warning/danger
     */
    function type(string $type)
    {
        $this->setAttribute("type", $type);
        return $this;
    }

    function closable(bool $closable = true)
    {
        $this->setAttribute("closable", $closable);
        return $this;
    }

    function disableTransitions(bool $disableTransitions = true)
    {
        $this->setAttribute("disable-transitions", $disableTransitions);
        return $this;
    }

    function hit(bool $hit = true)
    {
        $this->setAttribute("hit", $hit);
        return $this;
    }

    function color(string $color)
    {
        $this->setAttribute("color", $color);
        return $this;
    }

    /**
     * large / default /small
     */
    function size(string $size)
    {
        $this->setAttribute("size", $size);
        return $this;
    }

    /**
     * 	dark / light / plain
     */
    function effect(string $effect)
    {
        $this->setAttribute("effect", $effect);
        return $this;
    }

    /**
     * whether Tag is rounded
     */
    function round(bool $round = true)
    {
        $this->setAttribute("round", $round);
        return $this;
    }
}
