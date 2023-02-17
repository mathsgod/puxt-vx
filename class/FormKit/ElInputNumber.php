<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElInputNumber extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-input-number', $property, $translator);
    }

    public function min(int $min)
    {
        $this->property['min'] = $min;
        return $this;
    }

    public function max(int $max)
    {
        $this->property['max'] = $max;
        return $this;
    }

    public function step(int $step)
    {
        $this->property['step'] = $step;
        return $this;
    }
}