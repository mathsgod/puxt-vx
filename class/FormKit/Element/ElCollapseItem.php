<?php

namespace FormKit\Element;

use FormKit\ComponentNode;

class ElCollapseItem extends ComponentNode
{

    public function title(string $value)
    {
        $this->setAttribute('title', $value);
        return $this;
    }

    public function disabled(bool $value = true)
    {
        $this->setAttribute('disabled', $value);
        return $this;
    }
}
