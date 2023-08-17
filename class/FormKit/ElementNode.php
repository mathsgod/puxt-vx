<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElementNode extends SchemaNode
{

    protected $attrs = [];

    public function __construct(string $cmp, array $property = [], array $children = [])
    {
        $this->property = $property;
        $this->property['$el'] = $cmp;
        $this->children = $children;

        //parent::__construct($translator);
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
        $json = $this->property;

        if ($this->attrs) {
            $json['attrs'] = $this->attrs;
        }

        if ($this->children) {
            $json['children'] = $this->children;
        }
        return $json;
    }
}
