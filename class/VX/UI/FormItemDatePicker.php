<?php

namespace VX\UI;

use P\HTMLElement;
use VX\UI\FormItem;

class FormItemDatePicker extends HTMLElement
{

    public function __construct()
    {
        parent::__construct("el-date-picker");
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
