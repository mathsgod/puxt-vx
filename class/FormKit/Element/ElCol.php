<?php

namespace FormKit\Element;

use FormKit\ComponentNode;

class ElCol extends ComponentNode
{
    public function span(int $span)
    {
        $this->setAttribute('span', $span);
        return $this;
    }

    public function offset(int $offset)
    {
        $this->setAttribute('offset', $offset);
        return $this;
    }

    public function push(int $push)
    {
        $this->setAttribute('push', $push);
        return $this;
    }

    public function pull(int $pull)
    {
        $this->setAttribute('pull', $pull);
        return $this;
    }

    public function xs(int $xs)
    {
        $this->setAttribute('xs', $xs);
        return $this;
    }

    public function sm(int $sm)
    {
        $this->setAttribute('sm', $sm);
        return $this;
    }

    public function md(int $md)
    {
        $this->setAttribute('md', $md);
        return $this;
    }

    public function lg(int $lg)
    {
        $this->setAttribute('lg', $lg);
        return $this;
    }

    public function xl(int $xl)
    {
        $this->setAttribute('xl', $xl);
        return $this;
    }

    public function tag(string $tag)
    {
        $this->setAttribute('tag', $tag);
        return $this;
    }
}
