<?php

namespace FormKit\Element\Inputs;

class ElInput extends ElInputNode
{
    public function clearable()
    {
        $this->setAttribute("clearable", true);
        return $this;
    }
}
