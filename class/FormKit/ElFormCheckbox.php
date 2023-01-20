<?php

namespace FormKit;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormCheckbox extends FormKitComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormCheckbox', $property, $translator);
    }
}
