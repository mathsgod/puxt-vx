<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormColorPicker extends FormKitNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormColorPicker', $property, $translator);
    }
}
