<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QBadge extends ComponentNode
{

    // Content
    function floating(bool $floating = true)
    {
        $this->attributes["floating"] = $floating;
        return $this;
    }

    function multiLine(bool $multiLine = true)
    {
        $this->attributes["multi-line"] = $multiLine;
        return $this;
    }

    function label(string|int $label)
    {
        $this->attributes["label"] = $label;
        return $this;
    }

    /**
     * top|middle|bottom
     */
    function align(string $align)
    {
        $this->attributes["align"] = $align;
        return $this;
    }

    // Style
    function color(string $color)
    {
        $this->attributes["color"] = $color;
        return $this;
    }

    function textColor(string $textColor)
    {
        $this->attributes["text-color"] = $textColor;
        return $this;
    }

    function transparent(bool $transparent = true)
    {
        $this->attributes["transparent"] = $transparent;
        return $this;
    }

    function outline(bool $outline = true)
    {
        $this->attributes["outline"] = $outline;
        return $this;
    }

    function rounded(bool $rounded = true)
    {
        $this->attributes["rounded"] = $rounded;
        return $this;
    }
}
