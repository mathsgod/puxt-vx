<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElTextarea extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-textarea', $property, $translator);
    }
}
