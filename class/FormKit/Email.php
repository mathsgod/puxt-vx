<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Email extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('email', [], $translator);
    }

    public function placeholder(string $placeholder)
    {
        $this->property['placeholder'] = $placeholder;
        return $this;
    }
}
