<?php

namespace FormKit;

class ElInputNode extends FormKitNode
{
    public function formItem(bool $value = true)
    {
        $this->setProperty("form-item", $value);
        return $this;
    }
}
