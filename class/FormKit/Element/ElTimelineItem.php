<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElTimelineItem extends ComponentNode
{
    function timestamp($value)
    {
        $this->attributes['timestamp'] = $value;
        return $this;
    }

    function hideTimestamp(bool $value = true)
    {
        $this->attributes['hide-timestamp'] = $value;
        return $this;
    }

    function center(bool $value = true)
    {
        $this->attributes['center'] = $value;
        return $this;
    }

    /**
     * top / bottom
     */
    function placement(string $value)
    {
        $this->attributes['placement'] = $value;
        return $this;
    }

    /**
     * primary / success / warning / danger / info
     */
    function type(string $value)
    {
        $this->attributes['type'] = $value;
        return $this;
    }

    /**
     * 	hsl / hsv / hex / rgb
     */
    function color(string $value)
    {
        $this->attributes['color'] = $value;
        return $this;
    }

    /**
     * 	normal / large
     */
    function size(string $value)
    {
        $this->attributes['size'] = $value;
        return $this;
    }

    function icon(string $value)
    {
        $this->attributes['icon'] = $value;
        return $this;
    }

    function hollow(bool $value = true)
    {
        $this->attributes['hollow'] = $value;
        return $this;
    }
}
