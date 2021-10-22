<?php

namespace VX\UI\EL;

class ColorPicker extends Element
{
    function __construct()
    {
        parent::__construct("el-color-picker");
    }

    /**
     * whether to disable the ColorPicker
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }

    /**
     * size of ColorPicker
     * @param string $size medium / small / mini
     */
    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    /**
     * whether to display the alpha slider
     */
    function setShowAlpha(bool $show_alpha)
    {
        $this->setAttribute("show-alpha", $show_alpha);
    }

    /**
     * color format of v-model
     * @param string $format hsl / hsv / hex / rgb
     */
    function setColorFormat(string $format)
    {
        $this->setAttribute("color-format", $format);
    }

    /**
     * popper-class
     */
    function setPopperClass(string $class)
    {
        $this->setAttribute("popper-class", $class);
    }

    /**
     * predefined color options
     */
    function setPredefine(array $predefine)
    {
        $this->setAttribute(":predefine", json_encode($predefine, JSON_UNESCAPED_UNICODE));
    }

    /**
     * triggers when input value changes
     */
    function onChange(string $script)
    {
        $this->setAttribute("v-on:change", $script);
    }

    /**
     * triggers when the current active color changes
     */
    function onActiveChange(string $script)
    {
        $this->setAttribute("v-on:active-change", $script);
    }
}
