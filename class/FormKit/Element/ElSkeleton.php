<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElSkeleton extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("ElSkeleton", $property, $translator);
    }

    /**
     * whether showing the animation
     */
    function animated(bool $animated = true)
    {
        $this->props['animated'] = $animated;
        return $this;
    }

    /**
     * how many fake items to render to the DOM
     */
    function count(int $count)
    {
        $this->props['count'] = $count;
        return $this;
    }

    /**
     * whether showing the real DOM
     */
    function loading(bool $loading = true)
    {
        $this->props['loading'] = $loading;
        return $this;
    }

    /**
     * 	numbers of the row, only useful when no template slot were given
     */
    function rows(int $rows)
    {
        $this->props['rows'] = $rows;
        return $this;
    }

    /**
     * Rendering delay in milliseconds
     */
    function throttle(int $throttle)
    {
        $this->props['throttle'] = $throttle;
        return $this;
    }
}
