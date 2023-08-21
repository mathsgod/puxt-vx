<?php

namespace FormKit\Element\Inputs;

class ElPassword extends ElInputNode
{
    public function clearable(bool $clearable = true)
    {
        $this->setAttribute('clearable', $clearable);
        return $this;
    }

    public function showPassword(bool $showPassword = true)
    {
        $this->setAttribute('show-password', $showPassword);
        return $this;
    }
}
