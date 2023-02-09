<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElDescriptions extends ComponentBaseNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElDescriptions', $property, $translator);
    }

    public function addItem(?string $label = null, ?string $content = null)
    {
        $item = $this->addDescriptionsItem($label);
        if ($content) {
            $item->addChildren($content);
        }
        return $item;
    }

    public function item(?string $label = null, $content = null)
    {
        $item = $this->addItem($label);
        if ($content) {
            $item->addChildren($content);
        }

        return $this;
    }


    public function addDescriptionsItem(?string $label = null)
    {
        $item = new ElDescriptionsItem([], $this->translator);
        if ($label) {
            $item->label($label);
        }

        $this->children[] = $item;
        return $item;
    }

    /**
     * whether to show the border
     */
    public function border(bool $border = true)
    {
        $this->setProp('border', $border);
        return $this;
    }

    public function column(int $column)
    {
        $this->setProp('column', $column);
        return $this;
    }

    /**
     * direction of list
     */
    public function direction(string $direction)
    {
        $this->setProp('direction', $direction);
        return $this;
    }

    public function size(string $size)
    {
        $this->setProp('size', $size);
        return $this;
    }

    /**
     * whether to show the title
     */
    public function title(bool $title = true)
    {
        $this->setProp('title', $title);
        return $this;
    }

    public function extra(string $extra)
    {
        $this->setProp('extra', $extra);
        return $this;
    }
}
