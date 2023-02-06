<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElInput extends FormKitNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("elInput", $property, $translator);
    }
}
