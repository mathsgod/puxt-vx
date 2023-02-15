<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElUpload extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-upload', $property, $translator);
    }
}
