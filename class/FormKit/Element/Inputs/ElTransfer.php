<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;


class ElTransfer extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-transfer', $property, $translator);
    }
}
