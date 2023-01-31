<?php
namespace FormKit;

class Schema extends SchemaNode
{

    public function jsonSerialize()
    {
        return $this->children;
    }
}
