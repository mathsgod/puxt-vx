<?php

namespace FormKit;

class ElBadge extends ComponentNode
{
    public function __construct()
    {
        parent::__construct('ElBadge');
    }

    public function value($value)
    {
        $this->props['value'] = $value;
        return $this;
    }

    public function max(int $value)
    {
        $this->props['max'] = $value;
        return $this;
    }

    public function isDot(bool $value)
    {
        $this->props['isDot'] = $value;
        return $this;
    }

    public function hidden(bool $value)
    {
        $this->props['hidden'] = $value;
        return $this;
    }

    public function type(string $value)
    {
        $this->props['type'] = $value;
        return $this;
    }
}
