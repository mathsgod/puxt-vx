<?php

namespace FormKit;

use JsonSerializable;
use Symfony\Component\CssSelector\XPath\TranslatorInterface;

class Schema extends FormKitNode implements JsonSerializable
{

    public function jsonSerialize()
    {
        return $this->children;
    }
}
