<?php

namespace FormKit;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormCheckbox extends FormKitNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormCheckbox', $property, $translator);
    }
}
