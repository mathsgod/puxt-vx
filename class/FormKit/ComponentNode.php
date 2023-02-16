<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ComponentNode extends SchemaNode
{

    protected $props = [];

    public function __construct(string $cmp, array $props = [], ?TranslatorInterface $translator = null)
    {
        $this->props = $props;
        $this->property['$cmp'] = $cmp;
        parent::__construct($translator);
    }


    public function jsonSerialize()
    {
        $json = $this->property;
        if ($this->props) {
            $json['props'] = $this->props;
        }

        if ($this->children) {
            $json['children'] = $this->children;
        }

        return $json;
    }

    public function setProp(string $key, $value)
    {
        $this->props[$key] = $value;
        return $this;
    }
}
