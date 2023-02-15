<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElTimePicker extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-time-picker', $property, $translator);
    }
}
