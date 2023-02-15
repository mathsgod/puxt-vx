<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElSwitch extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-switch', $property, $translator);
    }
}
