<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;

class QBadge extends ComponentNode
{

    // Content
    function floating(bool $floating = true)
    {
        $this->setAttribute("floating", $floating);
        return $this;
    }

    function multiLine(bool $multiLine = true)
    {
        $this->setAttribute("multi-line", $multiLine);
        return $this;
    }

    function label(string|int $label)
    {
        $this->setAttribute("label", $label);
        return $this;
    }

    /**
     * top|middle|bottom
     */
    function align(string $align)
    {
        $this->setAttribute("align", $align);
        return $this;
    }

    // Style
    function color(string $color)
    {
        $this->setAttribute("color", $color);
        return $this;
    }

    function textColor(string $textColor)
    {
        $this->setAttribute("text-color", $textColor);
        return $this;
    }

    function transparent(bool $transparent = true)
    {
        $this->setAttribute("transparent", $transparent);
        return $this;
    }

    function outline(bool $outline = true)
    {
        $this->setAttribute("outline", $outline);
        return $this;
    }

    function rounded(bool $rounded = true)
    {
        $this->setAttribute("rounded", $rounded);
        return $this;
    }
}
