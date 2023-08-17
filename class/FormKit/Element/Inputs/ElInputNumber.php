<?php

namespace FormKit\Element\Inputs;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElInputNumber extends ElInputNode
{


    public function min(int $min)
    {
        $this->setAttribute('min', $min);
        return $this;
    }

    public function max(int $max)
    {
        $this->setAttribute('max', $max);
        return $this;
    }

    public function step(int $step)
    {
        $this->setAttribute('step', $step);
        return $this;
    }
}
