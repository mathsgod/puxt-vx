<?php

namespace FormKit;

class QIcon extends ComponentBaseNode
{
    public function __construct(array $props = [])
    {
        parent::__construct("QIcon", $props);
    }

    function name(string $name)
    {
        $this->setProp('name', $name);
        return $this;
    }
}
