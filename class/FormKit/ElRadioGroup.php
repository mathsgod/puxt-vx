<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElRadioGroup extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormRadioGroup', $property, $translator);
    }
}
