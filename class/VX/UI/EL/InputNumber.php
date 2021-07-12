<?php

namespace VX\UI\EL;

class InputNumber extends Element
{

    public function __construct()
    {
        parent::__construct("el-input-number");
    }

    public function setMin(int|float $min)
    {
        $this->setAttribute(":min", $min);
        return $this;
    }

    public function setMax(int|float $max)
    {
        $this->setAttribute(":max", $max);
        return $this;
    }

    public function setStep(int|float $max)
    {
        $this->setAttribute(":step", $max);
        return $this;
    }
}
