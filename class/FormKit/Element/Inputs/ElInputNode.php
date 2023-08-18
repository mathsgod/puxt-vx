<?php

namespace FormKit\Element\Inputs;

use FormKit\FormKitInputs;

class ElInputNode extends FormKitInputs
{
    public function options(array $options)
    {
        $this->setAttribute(":options", json_encode($options, JSON_UNESCAPED_UNICODE));
        return $this;
    }

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
