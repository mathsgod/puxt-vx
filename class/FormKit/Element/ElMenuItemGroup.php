<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElMenuItemGroup extends ComponentBaseNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("ElMenuItemGroup", $property, $translator);
    }

    function addMenuItem()
    {
        $item = new ElMenuItem([], $this->translator);
        $this->children[] = $item;
        return $item;
    }

    function title(string $value)
    {
        $this->props['title'] = $value;
        return $this;
    }
}
