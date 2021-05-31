<?php

namespace VX\UI;

use P\HTMLElement;

class View extends HTMLElement
{

    public function __construct()
    {
        parent::__construct("vx-view");
    }

    public function addItem(string $label, string $content)
    {
        $item = new ViewItem();

        $item->setLabel($label);

        $this->appendChild($item);

        $item->setContent($content);

        return $item;
    }

    public function add(string $label, $field)
    {

        return $this->addItem($label, var_get($this->data, $field));
    }

    public function setData($data)
    {
        $this->data = $data;
    }
}
