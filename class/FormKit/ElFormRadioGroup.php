<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormRadioGroup extends FormKitComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormRadioGroup', $property, $translator);
    }
}
