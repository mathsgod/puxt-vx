<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElProgress extends ComponentNode
{
    function percentage(int $percentage)
    {
        $this->attributes['percentage'] = $percentage;
        return $this;
    }

    /**
     * 'line' | 'circle' | 'dashboard'
     */
    function type(string $type)
    {
        $this->attributes['type'] = $type;
        return $this;
    }

    function strokeWidth(int $strokeWidth)
    {
        $this->attributes['stroke-width'] = $strokeWidth;
        return $this;
    }

    function textInside(bool $textInside)
    {
        $this->attributes['text-inside'] = $textInside;
        return $this;
    }

    /**
     * 'success' | 'exception' | 'warning'
     */
    function status(string $status)
    {
        $this->attributes['status'] = $status;
        return $this;
    }

    function indeterminate(bool $indeterminate)
    {
        $this->attributes['indeterminate'] = $indeterminate;
        return $this;
    }

    function duration(int $duration)
    {
        $this->attributes['duration'] = $duration;
        return $this;
    }

    function color(string $color)
    {
        $this->attributes['color'] = $color;
        return $this;
    }

    function width(int $width)
    {
        $this->attributes['width'] = $width;
        return $this;
    }

    function showText(bool $showText)
    {
        $this->attributes['show-text'] = $showText;
        return $this;
    }

    /**
     * 'butt' | 'round' | 'square'
     */
    function strokeLinecap(string $strokeLinecap)
    {
        $this->attributes['stroke-linecap'] = $strokeLinecap;
        return $this;
    }

    function format(string $format)
    {
        $this->attributes['format'] = $format;
        return $this;
    }
}
