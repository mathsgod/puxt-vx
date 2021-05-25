<?php

namespace VX\UI;

use P\HTMLElement;

use VX\UI\FormItem;

class FormItemInput extends HTMLElement
{

    public function __construct()
    {
        parent::__construct("el-input");
    }

    public function required(string $message = null)
    {
        $node = $this->parentNode;
        if ($node instanceof FormItem) {
            $node->required($message);
        }
        return $this;
    }

    public function placeholder(string $placeholder)
    {
        $this->setAttribute("placeholder", $placeholder);
        return $this;
    }
}
