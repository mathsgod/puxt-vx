<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Component\CssSelector\XPath\TranslatorInterface;

class ElScrollbar extends ComponentNode
{


    public function height(string|int $height)
    {
        $this->setAttribute('height', $height);
        return $this;
    }

    public function maxHeight(string|int $maxHeight)
    {
        $this->setAttribute('maxHeight', $maxHeight);
        return $this;
    }

    public function native(bool $native)
    {
        $this->setAttribute('native', $native);
        return $this;
    }

    public function wrapStyle(string $wrapStyle)
    {
        $this->setAttribute('wrapStyle', $wrapStyle);
        return $this;
    }

    public function wrapClass(string $wrapClass)
    {
        $this->setAttribute('wrapClass', $wrapClass);
        return $this;
    }

    public function viewStyle(string $viewStyle)
    {
        $this->setAttribute('viewStyle', $viewStyle);
        return $this;
    }

    public function viewClass(string $viewClass)
    {
        $this->setAttribute('viewClass', $viewClass);
        return $this;
    }

    public function noresize(bool $noresize)
    {
        $this->setAttribute('noresize', $noresize);
        return $this;
    }

    public function tag(string $tag)
    {
        $this->setAttribute('tag', $tag);
        return $this;
    }

    public function always(bool $always)
    {
        $this->setAttribute('always', $always);
        return $this;
    }

    public function minSize(int $minSize)
    {
        $this->setAttribute('minSize', $minSize);
        return $this;
    }
}
