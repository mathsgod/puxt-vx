<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElTimelineItem extends ComponentNode
{
    function timestamp($value)
    {
        $this->setAttribute('timestamp', $value);
        return $this;
    }

    function hideTimestamp(bool $value = true)
    {
        $this->setAttribute('hide-timestamp', $value);
        return $this;
    }

    function center(bool $value = true)
    {
        $this->setAttribute('center', $value);
        return $this;
    }

    /**
     * top / bottom
     */
    function placement(string $value)
    {
        $this->setAttribute('placement', $value);
        return $this;
    }

    /**
     * primary / success / warning / danger / info
     */
    function type(string $value)
    {
        $this->setAttribute('type', $value);
        return $this;
    }

    /**
     * 	hsl / hsv / hex / rgb
     */
    function color(string $value)
    {
        $this->setAttribute('color', $value);
        return $this;
    }

    /**
     * 	normal / large
     */
    function size(string $value)
    {
        $this->setAttribute('size', $value);
        return $this;
    }

    function icon(string $value)
    {
        $this->setAttribute('icon', $value);
        return $this;
    }

    function hollow(bool $value = true)
    {
        $this->setAttribute('hollow', $value);
        return $this;
    }
}
