<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormUpload extends FormKitComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormUpload', $property, $translator);
    }
}
