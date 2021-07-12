<?php

namespace VX\UI\EL;

use P\Element;

class FormItemElement extends Element
{
    public function required(string $message = null)
    {
        $node = $this->parentNode;
        if ($node instanceof FormItem) {
            $node->required($message);
        }
        return $this;
    }
}
