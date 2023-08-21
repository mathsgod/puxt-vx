<?php

namespace FormKit\Element\Inputs;

use FormKit\FormKitInputs;

class ElInputNode extends FormKitInputs
{
    public function options(array $options)
    {
        $this->setAttribute("options", $options);
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

    public function setAttribute(string $qualifiedName, $value)
    {
        if (!is_string($value)) {
            return parent::setAttribute(":{$qualifiedName}", json_encode($value, JSON_UNESCAPED_UNICODE));
        }
        return parent::setAttribute($qualifiedName, $value);
    }
}
