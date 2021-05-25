<?php

namespace VX\UI;

use P\HTMLElement;

class View extends HTMLElement
{

    public function __construct()
    {
        parent::__construct("vx-view");
    }

    public function addItem(string $label)
    {
        $item = new ViewItem();

        $item->setLabel($label);

        $this->appendChild($item);

        return $item;
    }

    
}
