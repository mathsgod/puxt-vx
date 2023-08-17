<?php

namespace FormKit\Element\Inputs;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElRadioGroup extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-radio-group', $property, $translator);
    }
}
