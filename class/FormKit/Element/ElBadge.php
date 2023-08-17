<?php

namespace FormKit\Element;

use FormKit\ComponentNode;

class ElBadge extends ComponentNode
{

    public function value($value)
    {
        $this->setAttribute('value', $value);
        return $this;
    }

    public function max(int $value)
    {
        $this->setAttribute('max', $value);
        return $this;
    }

    public function isDot(bool $value)
    {
        $this->setAttribute('is-dot', $value);
        return $this;
    }

    public function hidden(bool $value)
    {
        $this->setAttribute('hidden', $value);
        return $this;
    }

    public function type(string $value)
    {
        $this->setAttribute('type', $value);
        return $this;
    }
}
