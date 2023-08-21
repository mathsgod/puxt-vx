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
        $this->setAttribute('alignment', $align);
        return $this;
    }

    /**
     * Classname
     */
    function class(string|array $class)
    {
        $this->setAttribute('class', $class);
        return $this;
    }

    /**
     * Placement direction
     * 'vertical' | 'horizontal'
     */
    function direction(string $direction)
    {
        $this->setAttribute('direction', $direction);
        return $this;
    }

    /**
     * Prefix for space-items
     */
    function prefixCls(string $prefixCls)
    {
        $this->setAttribute('prefix-cls', $prefixCls);
        return $this;
    }

    /**
     * Extra style rules
     */
    function style(string|array $style)
    {
        $this->setAttribute('style', $style);
        return $this;
    }

    /**
     * Spacer
     */
    function spacer(string|int $spacer)
    {
        $this->setAttribute('spacer', $spacer);
        return $this;
    }

    /**
     * Spacing size
     * 'default' | 'small' | 'large'
     * [number, number]
     */
    function size(string|int|array $size)
    {
        $this->setAttribute('size', $size);
        return $this;
    }

    /**
     * Auto wrapping
     */
    function wrap(bool $wrap = true)
    {
        $this->setAttribute('wrap', $wrap);
        return $this;
    }

    /**
     * Whether to fill the container
     */
    function fill(bool $fill = true)
    {
        $this->setAttribute('fill', $fill);
        return $this;
    }

    /**
     * Ratio of fill
     */
    function fillRatio(int $fillRatio)
    {
        $this->setAttribute('fill-ratio', $fillRatio);
        return $this;
    }
}
