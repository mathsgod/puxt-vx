<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Autocomplete extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-autocomplete");
    }

    /**
     * the placeholder of Autocomplete
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
     * whether Autocomplete is disabled
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }

    /**
     * key name of the input suggestion object for display
     */
    function setValueKey(string $value_key)
    {
        $this->setAttribute("value-key", $value_key);
    }

    /**
     * icon name
     */
    function setIcon(string $icon)
    {
        $this->setAttribute("icon", $icon);
    }

    /**
     * binding value
     */
    function setValue(string $value)
    {
        $this->setAttribute("value", $value);
    }

    /**
     * debounce delay when typing, in milliseconds
     */
    function setDebounce(int $debounce)
    {
        $this->setAttribute(":debounce", $debounce);
    }

    /**
     * placement of the popup menu
     * @param string $placement top / top-start / top-end / bottom / bottom-start / bottom-end
     */
    function setPlacement(string $placement)
    {
        $this->setAttribute("placement", $placement);
    }

    
}
