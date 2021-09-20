<?php

namespace VX\UI\EL;

use P\Element;

class FormItemElement extends Element
{
    public function required(string $message = null)
    {
        $node = $this->parentNode;

        if ($node->tagName == "el-form-item") {
            $node->setAttribute("required", $message);
        }
        return $this;
    }
}
