<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElSpace extends ComponentNode
{


    /**
     * Controls the alignment of items, https://developer.mozilla.org/en-US/docs/Web/CSS/align-items
     */
    function alignment(string $align)
    {
        $this->attributes['align'] = $align;
        return $this;
    }

    /**
     * Classname
     */
    function class(string|array $class)
    {
        $this->attributes['class'] = $class;
        return $this;
    }

    /**
     * Placement direction
     * 'vertical' | 'horizontal'
     */
    function direction(string $direction)
    {
        $this->attributes['direction'] = $direction;
        return $this;
    }

    /**
     * Prefix for space-items
     */
    function prefixCls(string $prefixCls)
    {
        $this->attributes['prefixCls'] = $prefixCls;
        return $this;
    }

    /**
     * Extra style rules
     */
    function style(string|array $style)
    {
        $this->attributes['style'] = $style;
        return $this;
    }

    /**
     * Spacer
     */
    function spacer(string|int $spacer)
    {
        $this->attributes['spacer'] = $spacer;
        return $this;
    }

    /**
     * Spacing size
     * 'default' | 'small' | 'large'
     * [number, number]
     */
    function size(string|int|array $size)
    {
        $this->attributes['size'] = $size;
        return $this;
    }

    /**
     * Auto wrapping
     */
    function wrap(bool $wrap = true)
    {
        $this->attributes['wrap'] = $wrap;
        return $this;
    }

    /**
     * Whether to fill the container
     */
    function fill(bool $fill = true)
    {
        $this->attributes['fill'] = $fill;
        return $this;
    }

    /**
     * Ratio of fill
     */
    function fillRatio(int $fillRatio)
    {
        $this->attributes['fill-ratio'] = $fillRatio;
        return $this;
    }
}
