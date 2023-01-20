<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElCol extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElCol', $property, $translator);
    }

    public function span(int $span)
    {
        $this->setProperty('span', $span);
        return $this;
    }

    public function offset(int $offset)
    {
        $this->setProperty('offset', $offset);
        return $this;
    }

    public function push(int $push)
    {
        $this->setProperty('push', $push);
        return $this;
    }

    public function pull(int $pull)
    {
        $this->setProperty('pull', $pull);
        return $this;
    }

    public function xs(int $xs)
    {
        $this->setProperty('xs', $xs);
        return $this;
    }

    public function sm(int $sm)
    {
        $this->setProperty('sm', $sm);
        return $this;
    }

    public function md(int $md)
    {
        $this->setProperty('md', $md);
        return $this;
    }

    public function lg(int $lg)
    {
        $this->setProperty('lg', $lg);
        return $this;
    }

    public function xl(int $xl)
    {
        $this->setProperty('xl', $xl);
        return $this;
    }

    public function tag(string $tag)
    {
        $this->setProperty('tag', $tag);
        return $this;
    }
}
