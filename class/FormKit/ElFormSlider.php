<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormSlider extends FormKitComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormSlider', $property, $translator);
    }
}
