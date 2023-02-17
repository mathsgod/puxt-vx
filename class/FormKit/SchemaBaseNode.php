<?php

namespace FormKit;

use JsonSerializable;

abstract class SchemaBaseNode implements JsonSerializable
{

    protected $property = [];
    protected $children = [];

    public function id(string $id)
    {
        $this->property['id'] = $id;
        return $this;
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

    public function for(array $for)
    {
        $this->property['for'] = $for;
        return $this;
    }

    public function else(string $else)
    {
        $this->property['else'] = $else;
        return $this;
    }

    /**
     * @template T
     * @param T $children
     * @return T
     */
    public function addChildren($children)
    {
        if ($children !== null) {
            $this->children[] = $children;
        }

        return $children;
    }

    public function setProperty(string $key, $value)
    {
        $this->property[$key] = $value;
        return $this;
    }


    public function value($value)
    {
        $this->property["value"] = $value;
        return $this;
    }

    

    public function jsonSerialize()
    {
        $json = [];
        $json = $this->property;
        if ($this->children) {
            $json['children'] = $this->children;
        }
        return $json;
    }
}
