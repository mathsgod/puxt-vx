<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormItem extends ComponentNode
{
    public function __construct(array $props = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-form-item', $props, $translator);
    }

    public function label(string $label)
    {
        $this->setProp('label', $label);
        return $this;
    }

    public function labelWidth(string|int $width)
    {
        $this->setProp('label-width', $width);
        return $this;
    }

    public function size(string $size)
    {
        $this->setProp('size', $size);
        return $this;
    }
}
