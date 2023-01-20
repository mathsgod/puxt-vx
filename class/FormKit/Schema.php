<?php

namespace FormKit;

use JsonSerializable;

class Schema extends SchemaNode implements JsonSerializable
{
    public function jsonSerialize()
    {
        return $this->children;
    }
}
