<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElSelect extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-select', $property, $translator);
    }

    public function multiple()
    {
        $this->property['multiple'] = true;
        return $this;
    }
}
