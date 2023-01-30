<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormTimePicker extends FormKitNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormTimePicker', $property, $translator);
    }
}
