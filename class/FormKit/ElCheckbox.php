<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElCheckbox extends FormKitNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-checkbox', $property, $translator);
    }

    public function formItem(bool $value = true)
    {
        $this->setProperty("form-item", $value);
        return $this;
    }
}
