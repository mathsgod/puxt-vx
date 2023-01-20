<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormRate extends FormKitComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormRate', $property, $translator);
    }
}
