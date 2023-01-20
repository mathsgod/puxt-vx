<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormSwitch extends FormKitComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormSwitch', $property, $translator);
    }
}
