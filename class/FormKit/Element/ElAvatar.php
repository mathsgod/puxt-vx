<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;


class ElAvatar extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElAvatar', $property, $translator);
    }

    /**
     * 'large' | 'default' | 'small'
     */
    function size(string|int $size)
    {
        $this->props['size'] = $size;
        return $this;
    }

    /**
     * 'circle' | 'square'
     */
    function shape(string $shape)
    {
        $this->props['shape'] = $shape;
        return $this;
    }

    function src(string $src)
    {
        $this->props['src'] = $src;
        return $this;
    }

    function srcSet(string $srcSet)
    {
        $this->props['src-set'] = $srcSet;
        return $this;
    }

    function alt(string $alt)
    {
        $this->props['alt'] = $alt;
        return $this;
    }

    function icon(string $icon)
    {
        $this->props['icon'] = $icon;
        return $this;
    }

    /**
     * 'fill' | 'contain' | 'cover' | 'none' | 'scale-down'
     */
    function fit(string $fit)
    {
        $this->props['fit'] = $fit;
        return $this;
    }
}
