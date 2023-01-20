<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormTimeSelect extends FormKitComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormTimeSelect', $property, $translator);
    }
}
