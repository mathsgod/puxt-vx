<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElPassword extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-password', $property, $translator);
    }

    public function clearable()
    {
        $this->property['clearable'] = true;
        return $this;
    }
}
