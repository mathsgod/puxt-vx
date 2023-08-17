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
        $this->attributes['animated'] = $animated;
        return $this;
    }

    /**
     * how many fake items to render to the DOM
     */
    function count(int $count)
    {
        $this->attributes['count'] = $count;
        return $this;
    }

    /**
     * whether showing the real DOM
     */
    function loading(bool $loading = true)
    {
        $this->attributes['loading'] = $loading;
        return $this;
    }

    /**
     * 	numbers of the row, only useful when no template slot were given
     */
    function rows(int $rows)
    {
        $this->attributes['rows'] = $rows;
        return $this;
    }

    /**
     * Rendering delay in milliseconds
     */
    function throttle(int $throttle)
    {
        $this->attributes['throttle'] = $throttle;
        return $this;
    }
}
