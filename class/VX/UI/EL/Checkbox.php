<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Checkbox extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("el-checkbox");
    }


    public function required(string $message = null)
    {
        $node = $this->parentNode;
        if ($node instanceof FormItem) {
            $node->required($message);
        }
        return $this;
    }
}
