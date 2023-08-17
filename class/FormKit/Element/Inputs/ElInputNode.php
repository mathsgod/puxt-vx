<?php

namespace FormKit\Element\Inputs;

use FormKit\FormKitInputs;

class ElInputNode extends FormKitInputs
{
    public function formItem(bool $value = true)
    {
        if ($value) {
            $this->setAttribute("form-item", "");
        } else {
            $this->removeAttribute("form-item");
        }
        return $this;
    }
}
