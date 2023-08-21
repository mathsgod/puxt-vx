<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElProgress extends ComponentNode
{
    function percentage(int $percentage)
    {
        $this->setAttribute('percentage', $percentage);
        return $this;
    }

    /**
     * 'line' | 'circle' | 'dashboard'
     */
    function type(string $type)
    {
        $this->setAttribute('type', $type);
        return $this;
    }

    function strokeWidth(int $strokeWidth)
    {
        $this->setAttribute('stroke-width', $strokeWidth);
        return $this;
    }

    function textInside(bool $textInside)
    {
        $this->setAttribute('text-inside', $textInside);
        return $this;
    }

    /**
     * 'success' | 'exception' | 'warning'
     */
    function status(string $status)
    {
        $this->setAttribute('status', $status);
        return $this;
    }

    function indeterminate(bool $indeterminate)
    {
        $this->setAttribute('indeterminate', $indeterminate);
        return $this;
    }

    function duration(int $duration)
    {
        $this->setAttribute('duration', $duration);
        return $this;
    }

    function color(string $color)
    {
        $this->setAttribute('color', $color);
        return $this;
    }

    function width(int $width)
    {
        $this->setAttribute('width', $width);
        return $this;
    }

    function showText(bool $showText)
    {
        $this->setAttribute('show-text', $showText);
        return $this;
    }

    /**
     * 'butt' | 'round' | 'square'
     */
    function strokeLinecap(string $strokeLinecap)
    {
        $this->setAttribute('stroke-linecap', $strokeLinecap);
        return $this;
    }

    function format(string $format)
    {
        $this->setAttribute('format', $format);
        return $this;
    }
}
