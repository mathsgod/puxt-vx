<?php

namespace VX\UI\EL;

use P\Element as PElement;

class Element extends PElement
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
