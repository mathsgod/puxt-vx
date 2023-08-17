<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;


class ElAvatar extends ComponentNode
{

    /**
     * 'large' | 'default' | 'small'
     */
    function size(string|int $size)
    {
        $this->setAttribute('size', $size);
        return $this;
    }

    /**
     * 'circle' | 'square'
     */
    function shape(string $shape)
    {
        $this->setAttribute("shape", $shape);
        return $this;
    }

    function src(string $src)
    {
        $this->setAttribute('src', $src);
        return $this;
    }

    function srcSet(string $srcSet)
    {
        $this->setAttribute('srcSet', $srcSet);
        return $this;
    }

    function alt(string $alt)
    {
        $this->setAttribute('alt', $alt);
        return $this;
    }

    function icon(string $icon)
    {
        $this->setAttribute('icon', $icon);
        return $this;
    }

    /**
     * 'fill' | 'contain' | 'cover' | 'none' | 'scale-down'
     */
    function fit(string $fit)
    {
        $this->setAttribute('fit', $fit);
        return $this;
    }
}
