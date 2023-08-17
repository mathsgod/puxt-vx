<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElRate extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-rate', $property, $translator);
    }
}
