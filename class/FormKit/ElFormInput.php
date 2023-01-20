<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormInput extends FormKitComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormInput', $property, $translator);
    }

    public function clearable()
    {
        $this->property['clearable'] = true;
        return $this;
    }
}
