<?php


namespace VX\UI\EL;

use P\Element;

class OptionGroup extends Element
{
    public function __construct()
    {
        parent::__construct("el-option-group");
    }

    public function addOption($value, $label)
    {
        $option = new Option;
        $option->setValue($value);
        $option->setLabel($label);
        $this->append($option);
        return $option;
    }

    public function setLabel(string $label)
    {
        $this->setAttribute("label", $label);
    }
}
