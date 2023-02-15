<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElSlider extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-slider', $property, $translator);
    }
}
