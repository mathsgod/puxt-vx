<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElSpace extends ComponentNode
{
    public function __construct(array $props = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("ElSpace", $props, $translator);
    }

    /**
     * Controls the alignment of items, https://developer.mozilla.org/en-US/docs/Web/CSS/align-items
     */
    function alignment(string $align)
    {
        $this->props['align'] = $align;
        return $this;
    }

    /**
     * Classname
     */
    function class(string|array $class)
    {
        $this->props['class'] = $class;
        return $this;
    }

    /**
     * Placement direction
     * 'vertical' | 'horizontal'
     */
    function direction(string $direction)
    {
        $this->props['direction'] = $direction;
        return $this;
    }

    /**
     * Prefix for space-items
     */
    function prefixCls(string $prefixCls)
    {
        $this->props['prefixCls'] = $prefixCls;
        return $this;
    }

    /**
     * Extra style rules
     */
    function style(string|array $style)
    {
        $this->props['style'] = $style;
        return $this;
    }

    /**
     * Spacer
     */
    function spacer(string|int $spacer)
    {
        $this->props['spacer'] = $spacer;
        return $this;
    }

    /**
     * Spacing size
     * 'default' | 'small' | 'large'
     * [number, number]
     */
    function size(string|int|array $size)
    {
        $this->props['size'] = $size;
        return $this;
    }

    /**
     * Auto wrapping
     */
    function wrap(bool $wrap = true)
    {
        $this->props['wrap'] = $wrap;
        return $this;
    }

    /**
     * Whether to fill the container
     */
    function fill(bool $fill = true)
    {
        $this->props['fill'] = $fill;
        return $this;
    }

    /**
     * Ratio of fill
     */
    function fillRatio(int $fillRatio)
    {
        $this->props['fill-ratio'] = $fillRatio;
        return $this;
    }
}
