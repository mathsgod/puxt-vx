<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElTimeSelect extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-time-select', $property, $translator);
    }
}
