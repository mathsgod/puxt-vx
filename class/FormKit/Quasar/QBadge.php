<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QBadge extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('QBadge', $property, $translator);
    }

    // Content
    function floating(bool $floating = true)
    {
        $this->props["floating"] = $floating;
        return $this;
    }

    function multiLine(bool $multiLine = true)
    {
        $this->props["multi-line"] = $multiLine;
        return $this;
    }

    function label(string|int $label)
    {
        $this->props["label"] = $label;
        return $this;
    }

    /**
     * top|middle|bottom
     */
    function align(string $align)
    {
        $this->props["align"] = $align;
        return $this;
    }

    // Style
    function color(string $color)
    {
        $this->props["color"] = $color;
        return $this;
    }

    function textColor(string $textColor)
    {
        $this->props["text-color"] = $textColor;
        return $this;
    }

    function transparent(bool $transparent = true)
    {
        $this->props["transparent"] = $transparent;
        return $this;
    }

    function outline(bool $outline = true)
    {
        $this->props["outline"] = $outline;
        return $this;
    }

    function rounded(bool $rounded = true)
    {
        $this->props["rounded"] = $rounded;
        return $this;
    }
}
