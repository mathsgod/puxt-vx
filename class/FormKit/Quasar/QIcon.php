<?php

namespace FormKit\Quasar;

use FormKit\ComponentBaseNode;

class QIcon extends ComponentBaseNode
{

    /**
     * HTML tag to render, unless no icon is supplied or it's an svg icon
     */
    function tag(string $tag)
    {
        $this->attributes["tag"] = $tag;
        return $this;
    }

    /**
     * Useful if icon is on the left side of something: applies a standard margin on the right side of Icon
     */
    function left(bool $left = true)
    {
        $this->attributes["left"] = $left;
        return $this;
    }

    /**
     * Useful if icon is on the right side of something: applies a standard margin on the left side of Icon
     */
    function right(bool $right = true)
    {
        $this->attributes["right"] = $right;
        return $this;
    }

    /**
     * Icon name following Quasar convention; Make sure you have the icon library installed unless you are using 'img:' prefix; If 'none' (String) is used as value then no icon is rendered (but screen real estate will still be used for it)
     */
    function name(string $name)
    {
        $this->attributes["name"] = $name;
        return $this;
    }

    /**
     * Size in CSS units, including unit name or standard size name (xs|sm|md|lg|xl)
     */
    function size(string $size)
    {
        $this->attributes["size"] = $size;
        return $this;
    }

    /**
     * Color name for component from the Quasar Color Palette
     */
    function color(string $color)
    {
        $this->attributes["color"] = $color;
        return $this;
    }
}
