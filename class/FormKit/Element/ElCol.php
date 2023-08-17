<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElCol extends ComponentNode
{
    public function span(int $span)
    {
        $this->setProp('span', $span);
        return $this;
    }

    public function offset(int $offset)
    {
        $this->setProp('offset', $offset);
        return $this;
    }

    public function push(int $push)
    {
        $this->setProp('push', $push);
        return $this;
    }

    public function pull(int $pull)
    {
        $this->setProp('pull', $pull);
        return $this;
    }

    public function xs(int $xs)
    {
        $this->setProp('xs', $xs);
        return $this;
    }

    public function sm(int $sm)
    {
        $this->setProp('sm', $sm);
        return $this;
    }

    public function md(int $md)
    {
        $this->setProp('md', $md);
        return $this;
    }

    public function lg(int $lg)
    {
        $this->setProp('lg', $lg);
        return $this;
    }

    public function xl(int $xl)
    {
        $this->setProp('xl', $xl);
        return $this;
    }

    public function tag(string $tag)
    {
        $this->setProp('tag', $tag);
        return $this;
    }
}
