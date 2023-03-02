<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;

class ElCollapse extends ComponentBaseNode
{
    public function __construct()
    {
        parent::__construct('ElCollapse');
    }

    public function addItem(?string $title = null, ?string $name = null)
    {
        $item = new ElCollapseItem();
        if ($title) {
            $item->title($title);
        }

        if ($name) {
            $item->setProp("name", $name);
        }


        $this->addChildren($item);
        return $item;
    }

    function accordion(bool $value = true)
    {
        $this->props['accordion'] = $value;
        return $this;
    }
}
