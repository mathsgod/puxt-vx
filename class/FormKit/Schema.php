<?php

namespace FormKit;

use JsonSerializable;

class Schema implements JsonSerializable
{

    private $items = [];


    public function addItem(array $item)
    {
        $this->items[] = $item;
    }


    public function addElement(string $el, array $config = [])
    {
        $item = [
            '$el' => $el
        ];
        $item = array_merge($item, $config);
        $this->items[] = $item;
    }

    public function addComponent(string $cmp, array $config = [])
    {
        $item = [
            '$cmp' => $cmp
        ];
        $item = array_merge($item, $config);
        $this->items[] = $item;
    }

    public function addFormKit(string $formkit, array $config = [])
    {
        $item = [
            '$formkit' => $formkit,
        ];
        $item = array_merge($item, $config);
        $this->items[] = $item;
    }

    public function jsonSerialize()
    {
        return $this->items;
    }
}
