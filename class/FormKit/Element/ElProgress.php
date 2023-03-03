<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElProgress extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("ElProgress", $property, $translator);
    }

    function percentage(int $percentage)
    {
        $this->props['percentage']= $percentage;
        return $this;
    }

    /**
     * 'line' | 'circle' | 'dashboard'
     */
    function type(string $type)
    {
        $this->props['type']= $type;
        return $this;
    }

    function strokeWidth(int $strokeWidth)
    {
        $this->props['stroke-width']= $strokeWidth;
        return $this;
    }

    function textInside(bool $textInside)
    {
        $this->props['text-inside']= $textInside;
        return $this;
    }

    /**
     * 'success' | 'exception' | 'warning'
     */
    function status(string $status)
    {
        $this->props['status']= $status;
        return $this;
    }

    function indeterminate(bool $indeterminate)
    {
        $this->props['indeterminate']= $indeterminate;
        return $this;
    }

    function duration(int $duration)
    {
        $this->props['duration']= $duration;
        return $this;
    }

    function color(string $color)
    {
        $this->props['color']= $color;
        return $this;
    }

    function width(int $width)
    {
        $this->props['width']= $width;
        return $this;
    }

    function showText(bool $showText)
    {
        $this->props['show-text']= $showText;
        return $this;
    }

    /**
     * 'butt' | 'round' | 'square'
     */
    function strokeLinecap(string $strokeLinecap)
    {
        $this->props['stroke-linecap']= $strokeLinecap;
        return $this;
    }

    function format(string $format)
    {
        $this->props['format']= $format;
        return $this;
    }

}
