<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormSelect extends FormKitNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormSelect', $property, $translator);
    }

    public function multiple()
    {
        $this->property['multiple'] = true;
        return $this;
    }
}
