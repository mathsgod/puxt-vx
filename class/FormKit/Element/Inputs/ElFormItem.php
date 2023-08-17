<?php

namespace FormKit;

class ElFormItem extends ComponentNode
{

    public function label(string $label)
    {
        $this->setAttribute('label', $label);
        return $this;
    }

    public function labelWidth(string|int $width)
    {
        $this->setAttribute('label-width', $width);
        return $this;
    }

    public function size(string $size)
    {
        $this->setAttribute('size', $size);
        return $this;
    }
}
