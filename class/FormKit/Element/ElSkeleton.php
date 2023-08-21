<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElSkeleton extends ComponentNode
{

    /**
     * whether showing the animation
     */
    function animated(bool $animated = true)
    {
        $this->setAttribute('animated', $animated);
        return $this;
    }

    /**
     * how many fake items to render to the DOM
     */
    function count(int $count)
    {
        $this->setAttribute('count', $count);
        return $this;
    }

    /**
     * whether showing the real DOM
     */
    function loading(bool $loading = true)
    {
        $this->setAttribute('loading', $loading);
        return $this;
    }

    /**
     * 	numbers of the row, only useful when no template slot were given
     */
    function rows(int $rows)
    {
        $this->setAttribute('rows', $rows);
        return $this;
    }

    /**
     * Rendering delay in milliseconds
     */
    function throttle(int $throttle)
    {
        $this->setAttribute('throttle', $throttle);
        return $this;
    }
}
