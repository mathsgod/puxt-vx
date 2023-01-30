<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormTextarea extends FormKitNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormTextarea', $property, $translator);
    }
}
