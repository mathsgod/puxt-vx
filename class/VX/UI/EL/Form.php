<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Form extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-form");
    }


    /**
     * whether the form is inline
     */
    function setInline(bool $inline)
    {
        $this->setAttribute("inline", $inline);
    }

    /**
     * position of label. If set to 'left' or 'right', label-width prop is also required
     * @param string $position right / left / right / top
     */
    function setLabelPosition(string $position)
    {
        $this->setAttribute("label-position", $position);
    }

    /**
     * width of label, e.g. '50px'. All its direct child form items will inherit this value. Width auto is supported.
     */
    function setLabelWidth(string $width)
    {
        $this->setAttribute("label-width", $width);
    }

    /**
     * suffix of the label
     */
    function setLabelSuffix(string $suffix)
    {
        $this->setAttribute("label-suffix", $suffix);
    }

    /**
     * whether to hide a red asterisk (star) next to the required field label.
     */
    function setHideRequiredAsterisk(bool $hide)
    {
        $this->setAttribute("hide-required-asterisk", $hide);
    }

    /**
     * whether to show the error message
     */
    function setShowMessage(bool $show)
    {
        $this->setAttribute("show_message", $show);
    }

    /**
     * whether to display the error message inline with the form item
     */
    function setInlineMessage(bool $show)
    {
        $this->setAttribute("inline-message", $show);
    }

    /**
     * whether to display an icon indicating the validation result
     */
    function setStatusIcon(bool $status_icon)
    {
        $this->setAttribute("status-icon", $status_icon);
    }

    /**
     * whether to trigger validation when the rules prop is changed
     */
    function setValidateOnRuleChange(bool $validate_on_rule_change)
    {
        $this->setAttribute("validate-on-rule-change", $validate_on_rule_change);
    }

    /**
     * control the size of components in this form
     * @param string $size medium / small / mini
     */
    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    /**
     * whether to disabled all components in this form. If set to true, it cannot be overridden by its inner components' disabled prop
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }
}
