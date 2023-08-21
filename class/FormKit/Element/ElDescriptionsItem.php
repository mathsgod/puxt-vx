<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElDescriptionsItem extends ComponentNode
{
    /**
     * label text
     */
    public function label(string $label)
    {
        $this->setAttribute('label', $this->translator ? $this->translator->trans($label) : $label);
        return $this;
    }

    /**
     * colspan of column
     */
    public function span(int $span)
    {
        $this->setAttribute('span', $span);
        return $this;
    }

    /**
     * column width, the width of the same column in different rows is set by the max value (If no border, width contains label and content)
     */
    public function width(string|int $width)
    {
        $this->setAttribute('width', $width);
        return $this;
    }

    public function minWidth(string|int $minWidth)
    {
        $this->setAttribute('min-width', $minWidth);
        return $this;
    }

    public function align(string $align)
    {
        $this->setAttribute('align', $align);
        return $this;
    }

    public function labelAlign(string $labelAlign)
    {
        $this->setAttribute('label-align', $labelAlign);
        return $this;
    }

    public function className(string $className)
    {
        $this->setAttribute('class-name', $className);
        return $this;
    }
}
