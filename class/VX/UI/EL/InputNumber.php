<?php

namespace VX\UI\EL;

class InputNumber extends Element
{

    function __construct()
    {
        parent::__construct("el-input-number");
    }

    /**
     * the minimum allowed value
     */
    function setMin(int|float $min)
    {
        $this->setAttribute(":min", $min);
    }

    /**
     * the maximum allowed value
     */
    function setMax(int|float $max)
    {
        $this->setAttribute(":max", $max);
    }

    /**
     * incremental step
     */
    function setStep(int|float $max)
    {
        $this->setAttribute(":step", $max);
    }

    /**
     * whether input value can only be multiple of step
     */
    function setStepStrictly(bool $step_strictly)
    {
        $this->setAttribute("step-strictly", $step_strictly);
    }

    /**
     * precision of input value
     */
    function setPrecision(int $precision)
    {
        $this->setAttribute(":precision", $precision);
    }

    /**
     * size of the component
     * @param string $size large/medium/small/mini
     */
    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    /**
     * whether the component is disabled
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }

    /**
     * whether to enable the control buttons
     */
    function setControls(bool $controls)
    {
        $this->setAttribute("controls", $controls);
    }

    /**
     * position of the control buttons
     */
    function setControlsPosition(string $position)
    {
        $this->setAttribute("controls-position", $position);
    }

    /**
     * same as name in native input
     */
    function setName(string $name)
    {
        $this->setAttribute("name", $name);
    }

    /**
     * label text
     */
    function setLabel(string $label)
    {
        $this->setAttribute("label", $label);
    }

    /**
     * placeholder in input
     */
    function setPlaceholder(string $placeholder)
    {
        $this->setAttribute("placeholder", $placeholder);
    }

    /**
     * triggers when the value changes
     */
    function onChange(string $script)
    {
        $this->setAttribute("v-on:change", $script);
    }

    /**
     * triggers when Input blurs
     */
    function onBlur(string $script)
    {
        $this->setAttribute("v-on:blur", $script);
    }

    /**
     * triggers when Input focuses
     */
    function onFocus(string $script)
    {
        $this->setAttribute("v-on:focus", $script);
    }
}
