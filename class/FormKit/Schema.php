<?php

namespace FormKit;

use JsonSerializable;
use Symfony\Component\CssSelector\XPath\TranslatorInterface;

class Schema extends SchemaNode implements JsonSerializable
{

    public function jsonSerialize()
    {
        return $this->children;
    }
}
