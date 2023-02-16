<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElCheckboxGroup extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-checkbox-group', $property, $translator);
    }
}
