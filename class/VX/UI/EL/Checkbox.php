<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Checkbox extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("el-checkbox");
    }

    /**
     * value of the Checkbox when used inside a checkbox-group
     */
    function setLabel(string|int|bool $label)
    {
        if (is_string($label)) {
            $this->setAttribute("label", $label);
        } elseif (is_bool($label)) {
            $this->setAttribute(":label", $label ? "true" : "false");
        } else {
            $this->setAttribute(":label", $label);
        }
    }

    /**
     * value of the Checkbox if it's checked
     */
    function setTrueLabel(string|int $label)
    {
        if (is_string($label)) {
            $this->setAttribute("true-label", $label);
        } else {
            $this->setAttribute(":true-label", $label);
        }
    }

    /**
     * value of the Checkbox if it's not checked
     */
    function setFalseLabel(string|int $label)
    {
        if (is_string($label)) {
            $this->setAttribute("false-label", $label);
        } else {
            $this->setAttribute(":false-label", $label);
        }
    }

    /**
     * whether the Checkbox is disabled
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }

    /**
     * whether to add a border around Checkbox
     */
    function setBorder(bool $border)
    {
        $this->setAttribute("border", $border);
    }

    /**
     * size of the Checkbox, only works when border is true
     * @param string $size medium / small / mini
     */
    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    /**
     * native 'name' attribute
     */
    function setName(string $name)
    {
        $this->setAttribute("name", $name);
    }

    /**
     * if the Checkbox is checked
     */
    function setChecked(bool $checked)
    {
        $this->setAttribute("checked", $checked);
    }

    /**
     * same as indeterminate in native checkbox
     */
    function setIndeterminate(bool $indeterminate)
    {
        $this->setAttribute("indeterminate", $indeterminate);
    }

    function onChange(string $script)
    {
        $this->setAttribute("v-on:change", $script);
    }



    public function required(string $message = null)
    {
        $node = $this->parentNode;
        if ($node instanceof FormItem) {
            $node->required($message);
        }
        return $this;
    }
}
