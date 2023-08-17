<?php

namespace FormKit\Element\Inputs;



class ElPassword extends ElInputNode
{
    public function clearable()
    {
        $this->setAttribute('clearable', true);
        return $this;
    }
}
