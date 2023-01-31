<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ComponentBaseNode extends SchemaBaseNode
{

    public $props = [];
    protected $translator;


    public function __construct(string $cmp, array $props = [], ?TranslatorInterface $translator = null)
    {
        $this->props = $props;
        $this->property['$cmp'] = $cmp;
        $this->translator = $translator;
    }

    public function setClass(string $class)
    {
        $this->setProp('class', $class);
        return $this;
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
