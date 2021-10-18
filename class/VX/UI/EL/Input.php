<?php

namespace VX\UI\EL;

class Input extends FormItemElement
{
    function __construct()
    {
        parent::__construct("el-input");
    }

    /**
     * type of input
     */
    function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }

    /**
     * same as maxlength in native input
     */
    function setMaxlength(int $length)
    {
        $this->setAttribute(":maxlength", $length);
    }

    /**
     * same as minlength in native input
     */
    function setMinlength(int $length)
    {
        $this->setAttribute(":minlength", $length);
    }

    /**
     * whether show word count，only works when type is 'text' or 'textarea'
     */
    function setShowWordLimit(bool $show_word_limit)
    {
        $this->setAttribute("show-word-limit", $show_word_limit);
    }

    /**
     * placeholder of Input
     */
    function setPlaceholder(string $placeholder)
    {
        $this->setAttribute("placeholder", $placeholder);
    }

    /**
     * whether to show clear button
     */
    function setClearable(bool $clearable)
    {
        $this->setAttribute("clearable", $clearable);
    }

    /**
     * whether to show toggleable password input
     */
    function setShowPassword(bool $show)
    {
        $this->setAttribute("show-password", $show);
    }

    /**
     * whether Input is disabled
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }

    /**
     * size of Input, works when type is not 'textarea'
     * @param string $size medium / small / mini
     */
    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    /**
     * prefix icon class
     */
    function setPrefixIcon(string $icon)
    {
        $this->setAttribute("prefix-icon", $icon);
    }

    /**
     * suffix icon class
     */
    function setSuffixIcon(string $icon)
    {
        $this->setAttribute("suffix-icon", $icon);
    }

    /**
     * number of rows of textarea, only works when type is 'textarea'
     */
    function setRows(int $rows)
    {
        $this->setAttribute(":rows", $rows);
    }

    /**
     * whether textarea has an adaptive height, only works when type is 'textarea'. Can accept an object, e.g. { minRows: 2, maxRows: 6 }
     */
    function setAutosize(bool|array $autosize)
    {
        if (is_bool($autosize)) {
            $this->setAttribute("autosize", $autosize);
        } else {
            $this->setAttribute(":autosize", json_encode($autosize, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * same as autocomplete in native input
     */
    function setAutocomplete(bool $autocomplete)
    {
        $this->setAttribute("autocomplete", $autocomplete);
    }

    /**
     * same as name in native input
     */
    function setName(string $name)
    {
        $this->setAttribute("name", $name);
    }

    /**
     * same as readonly in native input
     */
    function setReadonly(bool $readonly)
    {
        $this->setAttribute("readonly", $readonly);
    }

    /**
     * same as max in native input
     */
    function setMax($max)
    {
        $this->setAttribute("max", $max);
    }

    /**
     * same as min in native input
     */
    function setMin($min)
    {
        $this->setAttribute("min", $min);
    }

    /**
     * same as step in native input
     */
    function setStep($step)
    {
        $this->setAttribute("step", $step);
    }

    /**
     * control the resizability
     * @param string $resize none, both, horizontal, vertical
     */
    function setResize(string $resize)
    {
        $this->setAttribute("resize", $resize);
    }

    /**
     * same as autofocus in native input
     */
    function setAutofocus(bool $autofocus)
    {
        $this->setAttribute("autofocus", $autofocus);
    }

    /**
     * same as form in native input
     */
    function setForm(string $form)
    {
        $this->setAttribute("form", $form);
    }

    /**
     * label text
     */
    function setLabel(string $label)
    {
        $this->setAttribute("label", $label);
    }

    /**
     * input tabindex
     */
    function setTabindex(string $index)
    {
        $this->setAttribute("tabindex", $index);
    }

    /**
     * whether to trigger form validation
     */
    function setValidateEvent(bool $validate_event)
    {
        $this->setAttribute("validate-event", $validate_event);
    }
}
