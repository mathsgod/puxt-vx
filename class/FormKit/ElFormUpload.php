<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormUpload extends FormKitNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormUpload', $property, $translator);
    }
}
