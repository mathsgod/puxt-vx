<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;

class ElMenuItemGroup extends ComponentBaseNode
{

    function addMenuItem()
    {
        return $this->appendHTML('<el-menu-item></el-menu-item>')[0];
    }

    function title(string $value)
    {
        $this->setAttribute('title', $value);
        return $this;
    }
}
