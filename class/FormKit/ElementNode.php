<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElementNode extends SchemaNode
{

    protected $attrs = [];

    public function __construct(string $cmp, array $property = [], ?TranslatorInterface $translator = null)
    {
        $this->property = $property;
        $this->property['$el'] = $cmp;

        parent::__construct($translator);
    }

    public function attr(string $name, $value)
    {
        $this->attrs[$name] = $value;
        return $this;
    }

    public function attrs(array $attrs)
    {
        $this->attrs = $attrs;
        return $this;
    }

    public function jsonSerialize()
    {
        return array_merge(
            $this->property,
            [
                "attrs" => $this->attrs,
                "children" => $this->children
            ]
        );
    }
}
