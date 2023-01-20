<?php

namespace FormKit;

use Symfony\Component\CssSelector\XPath\TranslatorInterface;

class ElScrollbar extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElScrollbar', $property, $translator);
    }

    public function height(string|int $height)
    {
        $this->setProperty('height', $height);
        return $this;
    }

    public function maxHeight(string|int $maxHeight)
    {
        $this->setProperty('maxHeight', $maxHeight);
        return $this;
    }

    public function native(bool $native)
    {
        $this->setProperty('native', $native);
        return $this;
    }

    public function wrapStyle(string $wrapStyle)
    {
        $this->setProperty('wrapStyle', $wrapStyle);
        return $this;
    }

    public function wrapClass(string $wrapClass)
    {
        $this->setProperty('wrapClass', $wrapClass);
        return $this;
    }

    public function viewStyle(string $viewStyle)
    {
        $this->setProperty('viewStyle', $viewStyle);
        return $this;
    }

    public function viewClass(string $viewClass)
    {
        $this->setProperty('viewClass', $viewClass);
        return $this;
    }

    public function noresize(bool $noresize)
    {
        $this->setProperty('noresize', $noresize);
        return $this;
    }

    public function tag(string $tag)
    {
        $this->setProperty('tag', $tag);
        return $this;
    }

    public function always(bool $always)
    {
        $this->setProperty('always', $always);
        return $this;
    }

    public function minSize(int $minSize)
    {
        $this->setProperty('minSize', $minSize);
        return $this;
    }
}
