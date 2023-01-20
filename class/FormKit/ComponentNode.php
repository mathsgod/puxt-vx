<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ComponentNode extends SchemaNode
{

    public $props = [];

    public function __construct(string $cmp, array $property = [], ?TranslatorInterface $translator = null)
    {
        $this->property = $property;
        $this->property['$cmp'] = $cmp;
        parent::__construct($translator);
    }


    public function jsonSerialize()
    {
        return array_merge(
            $this->property,
            [
                "props" => $this->props,
                "children" => $this->children
            ]
        );
    }

    public function setProperty(string $key, $value)
    {
        $this->props[$key] = $value;
        return $this;
    }
}
