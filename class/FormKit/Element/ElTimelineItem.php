<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElTimelineItem extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElTimelineItem', $property, $translator);
    }

    function timestamp($value)
    {
        $this->props['timestamp'] = $value;
        return $this;
    }

    function hideTimestamp(bool $value = true)
    {
        $this->props['hide-timestamp'] = $value;
        return $this;
    }

    function center(bool $value = true)
    {
        $this->props['center'] = $value;
        return $this;
    }

    /**
     * top / bottom
     */
    function placement(string $value)
    {
        $this->props['placement'] = $value;
        return $this;
    }

    /**
     * primary / success / warning / danger / info
     */
    function type(string $value)
    {
        $this->props['type'] = $value;
        return $this;
    }

    /**
     * 	hsl / hsv / hex / rgb
     */
    function color(string $value)
    {
        $this->props['color'] = $value;
        return $this;
    }

    /**
     * 	normal / large
     */
    function size(string $value)
    {
        $this->props['size'] = $value;
        return $this;
    }

    function icon(string $value)
    {
        $this->props['icon'] = $value;
        return $this;
    }

    function hollow(bool $value = true)
    {
        $this->props['hollow'] = $value;
        return $this;
    }
}
