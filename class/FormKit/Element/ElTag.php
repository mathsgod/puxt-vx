<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElTag extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElTag', $property, $translator);
    }

    /**
     * success/info/warning/danger
     */
    function type(string $type)
    {
        $this->props["type"] = $type;
        return $this;
    }

    function closable(bool $closable = true)
    {
        $this->props["closable"] = $closable;
        return $this;
    }

    function disableTransitions(bool $disableTransitions = true)
    {
        $this->props["disable-transitions"] = $disableTransitions;
        return $this;
    }

    function hit(bool $hit = true)
    {
        $this->props["hit"] = $hit;
        return $this;
    }

    function color(string $color)
    {
        $this->props["color"] = $color;
        return $this;
    }

    /**
     * large / default /small
     */
    function size(string $size)
    {
        $this->props["size"] = $size;
        return $this;
    }

    /**
     * 	dark / light / plain
     */
    function effect(string $effect)
    {
        $this->props["effect"] = $effect;
        return $this;
    }

    /**
     * whether Tag is rounded
     */
    function round(bool $round = true)
    {
        $this->props["round"] = $round;
        return $this;
    }
}
