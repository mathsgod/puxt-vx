<?php

namespace FormKit\Element;

use FormKit\ComponentNode;

class ElCollapseItem extends ComponentNode
{
    public function __construct()
    {
        parent::__construct('ElCollapseItem');
    }

    public function title(string $value)
    {
        $this->props['title'] = $value;
        return $this;
    }

    public function disabled(bool $value = true)
    {
        $this->props['disabled'] = $value;
        return $this;
    }
}
