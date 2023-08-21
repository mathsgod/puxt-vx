<?php

namespace FormKit\Element\Inputs;



class ElPassword extends ElInputNode
{
    public function clearable()
    {
        $this->setAttribute('clearable', "");
        return $this;
    }

    public function showPassword()
    {

        $this->setAttribute('show-password', "");
        return $this;
    }
}
