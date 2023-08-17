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

        $this->attributes["type"] = $type;
        return $this;
    }

    function closable(bool $closable = true)
    {
        $this->attributes["closable"] = $closable;
        return $this;
    }

    function disableTransitions(bool $disableTransitions = true)
    {
        $this->attributes["disable-transitions"] = $disableTransitions;
        return $this;
    }

    function hit(bool $hit = true)
    {
        $this->attributes["hit"] = $hit;
        return $this;
    }

    function color(string $color)
    {
        $this->attributes["color"] = $color;
        return $this;
    }

    /**
     * large / default /small
     */
    function size(string $size)
    {
        $this->attributes["size"] = $size;
        return $this;
    }

    /**
     * 	dark / light / plain
     */
    function effect(string $effect)
    {
        $this->attributes["effect"] = $effect;
        return $this;
    }

    /**
     * whether Tag is rounded
     */
    function round(bool $round = true)
    {
        $this->attributes["round"] = $round;
        return $this;
    }
}
