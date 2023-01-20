<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;


class ElFormTransfer extends FormKitComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormTransfer', $property, $translator);
    }
}
