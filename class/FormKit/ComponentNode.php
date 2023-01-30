<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ComponentNode extends SchemaNode
{

    public $props = [];

    public function __construct(string $cmp, array $props = [], ?TranslatorInterface $translator = null)
    {
        $this->props = $props;
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

    public function setProp(string $key, $value)
    {
        $this->props[$key] = $value;
        return $this;
    }
}
