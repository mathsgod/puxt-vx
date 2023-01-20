<?php

namespace FormKit;

use JsonSerializable;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class SchemaNode implements JsonSerializable
{
    protected $property = [];
    protected $children = [];
    protected $translator;

    public function __construct(?TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
    }

    public function if(string $if)
    {
        $this->property['if'] = $if;
        return $this;
    }

    public function then(string $then)
    {
        $this->property['then'] = $then;
        return $this;
    }

    public function for(string $for)
    {
        $this->property['for'] = $for;
        return $this;
    }

    public function else(string $else)
    {
        $this->property['else'] = $else;
        return $this;
    }


    public function children(array|string|JsonSerializable $children)
    {
        $this->children = $children;
        return $this;
    }

    public function props(array $props)
    {
        $this->property['props'] = $props;
        return $this;
    }

    public function addElement(string $el, array $property = [])
    {
        $item = new ElementNode($el, $property, $this->translator);
        $this->children[] = $item;
        return $item;
    }

    public function addComponent(string $cmp, array $property = [])
    {
        $node = new ComponentNode($cmp, $property);
        $this->children[] = $node;
        return $node;
    }

    public function addFormKitComponent(string $formkit, array $property = [])
    {
        $node = new FormKitNodeComponent($formkit, $property, $this->translator);
        $this->children[] = $node;
        return $node;
    }

    public function jsonSerialize()
    {
        return array_merge($this->property, ["children" => $this->children]);
    }

    public function addChildren(string|JsonSerializable $children)
    {
        $this->children[] = $children;
        return $this;
    }

}
