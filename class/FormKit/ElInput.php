<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElInput extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("el-input", $property, $translator);
    }

    public function clearable()
    {
        $this->property['clearable'] = true;
        return $this;
    }
}
