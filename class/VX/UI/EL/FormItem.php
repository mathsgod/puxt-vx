<?php

namespace VX\UI\EL;

use P\CustomEvent;
use P\HTMLElement;
use VX\FileManager;
use VX\UI\InputXlsx;

class FormItem extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("el-form-item");
    }

    /**
     * a key of model. In the use of validate and resetFields method, the attribute is required
     */
    function setProp(string $prop)
    {
        $this->setAttribute("prop", $prop);
    }

    /**
     * label
     */
    function setLabel(string $label)
    {
        $this->setAttribute("label", $label);
    }

    /**
     * width of label, e.g. '50px'. Width auto is supported.
     */
    function setLabelWidth(string $width)
    {
        $this->setAttribute("label-width", $width);
    }

    /**
     * 	whether the field is required or not, will be determined by validation rules if omitted
     */
    function setRequired(bool $required)
    {
        $this->setAttribute("required", $required);
    }

    /**
     * field error message, set its value and the field will validate error and show this message immediately
     */
    function setError(string $error)
    {
        $this->setAttribute("error", $error);
    }

    /**
     * whether to show the error message
     */
    function setShowMessage(bool $show)
    {
        $this->setAttribute("show-message", $show);
    }

    /**
     * inline style validate message
     */
    function setInlineMessage(bool $inline_message)
    {
        $this->setAttribute("inline-message", $inline_message);
    }

    /**
     * control the size of components in this form-item
     * @param string $size medium / small / mini
     */
    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }
}
