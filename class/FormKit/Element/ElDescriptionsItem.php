<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElDescriptionsItem extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElDescriptionsItem', $property, $translator);
    }

    /**
     * label text
     */
    public function label(string $label)
    {
        $this->setProp('label', $this->translator ? $this->translator->trans($label) : $label);
        return $this;
    }

    /**
     * colspan of column
     */
    public function span(int $span)
    {
        $this->setProp('span', $span);
        return $this;
    }

    /**
     * column width, the width of the same column in different rows is set by the max value (If no border, width contains label and content)
     */
    public function width(string|int $width)
    {
        $this->setProp('width', $width);
        return $this;
    }

    public function minWidth(string|int $minWidth)
    {
        $this->setProp('min-width', $minWidth);
        return $this;
    }

    public function align(string $align)
    {
        $this->setProp('align', $align);
        return $this;
    }

    public function labelAlign(string $labelAlign)
    {
        $this->setProp('label-align', $labelAlign);
        return $this;
    }

    public function className(string $className)
    {
        $this->setProp('class-name', $className);
        return $this;
    }
}
