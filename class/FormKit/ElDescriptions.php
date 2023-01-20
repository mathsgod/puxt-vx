<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElDescriptions extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElDescriptions', $property, $translator);
    }

    public function addDescriptionsItem()
    {
        $item = new ElDescriptionsItem([], $this->translator);
        $this->children[] = $item;
        return $item;
    }

    /**
     * whether to show the border
     */
    public function border(bool $border = true)
    {
        $this->setProperty('border', $border);
        return $this;
    }

    public function column(int $column)
    {
        $this->setProperty('column', $column);
        return $this;
    }

    /**
     * direction of list
     */
    public function direction(string $direction)
    {
        $this->setProperty('direction', $direction);
        return $this;
    }

    public function size(string $size)
    {
        $this->setProperty('size', $size);
        return $this;
    }

    /**
     * whether to show the title
     */
    public function title(bool $title = true)
    {
        $this->setProperty('title', $title);
        return $this;
    }

    public function extra(string $extra)
    {
        $this->setProperty('extra', $extra);
        return $this;
    }
}
