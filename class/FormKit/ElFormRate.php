<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormRate extends FormKitNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormRate', $property, $translator);
    }
}
