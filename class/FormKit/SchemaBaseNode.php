<?php

namespace FormKit;

use JsonSerializable;

abstract class SchemaBaseNode implements JsonSerializable
{

    protected $property = [];
    protected $children = [];


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

    public function addChildren(string|JsonSerializable $children)
    {
        $this->children[] = $children;
        return $this;
    }

    public function setProperty(string $key, $value)
    {
        $this->property[$key] = $value;
        return $this;
    }

    public function jsonSerialize()
    {
        return array_merge(
            $this->property,
            [
                "children" => $this->children
            ]
        );
    }
}
