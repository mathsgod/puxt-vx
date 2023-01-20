<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormPassword extends FormKitComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormPassword', $property, $translator);
    }

    public function clearable()
    {
        $this->property['clearable'] = true;
        return $this;
    }
}
