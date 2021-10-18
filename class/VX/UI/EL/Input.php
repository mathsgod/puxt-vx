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
}
