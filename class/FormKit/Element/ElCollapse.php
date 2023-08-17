<?php

namespace FormKit\Element;

use FormKit\ComponentNode;

class ElCollapse extends ComponentNode
{
    public function addItem(?string $title = null, ?string $name = null)
    {
        $item = $this->appendHTML('<el-collapse-item></el-collapse-item>')[0];
        if ($title) {
            $item->title($title);
        }

        if ($name) {
            $item->setAttribute('name', $name);
        }
        return $item;
    }

    function accordion(bool $value = true)
    {
        $this->setAttribute('accordion', $value);
        return $this;
    }
}
