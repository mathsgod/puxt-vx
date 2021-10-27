<?php

namespace VX\UI;

use P\HTMLElement;

class Menu extends EL\Menu
{
    function add(string $label, string $uri, ?string $icon = null)
    {
        $item = $this->addItem();
        $item->textContent = $label;
        $item->setAttribute("index", $uri);
        if ($icon) {
            $i = new HTMLElement("i");
            $i->classList->add($icon);
            $item->prependChild($i);
        }
        return $item;
    }
}
