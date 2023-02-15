<?php

namespace FormKit;

use Symfony\Component\Translation\Translator;

class ElForm extends FormKitNode
{
    public function __construct(array $property = [], Translator $translator = null)
    {
        parent::__construct("el-form", $property, $translator);
    }
}
