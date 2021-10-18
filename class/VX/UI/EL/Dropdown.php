<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Dropdown extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-dropdown");
    }

    /**
     * menu button type, refer to Button Component, only works when split-button is true
     * @param string $type primary / success / warning / danger / info / text
     */
    function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }

    /**
     * menu size, also works on the split button
     * @param string $size medium / small / mini
     */
    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    /**
     * whether a button group is displayed
     */
    function setSplitButton(bool $split_button)
    {
        $this->setAttribute("split-button", $split_button);
    }

    /**
     * placement of pop menu
     * @param string $placement top/top-start/top-end/bottom/bottom-start/bottom-end
     */
    function setPlacement(string $placement)
    {
        $this->setAttribute("placement", $placement);
    }

    /**
     * how to trigger
     * @param string $trigger hover/click
     */
    function setTrigger(string $trigger)
    {
        $this->setAttribute("trigger", $trigger);
    }

    /**
     * whether to hide menu after clicking menu-item
     */
    function setHideOnClick(bool $hide_on_click)
    {
        $this->setAttribute("hide-on-click", $hide_on_click);
    }

    /**
     * Delay time before show a dropdown (only works when trigger is hover)
     */
    function setShowTimeout(int $time)
    {
        $this->setAttribute(":show-timeout", $time);
    }

    /**
     * Delay time before hide a dropdown (only works when trigger is hover)
     */
    function setHideTimeout(int $time)
    {
        $this->setAttribute(":hide-timeout", $time);
    }

    /**
     * tabindex of Dropdown
     */
    function setTabindex(int $index)
    {
        $this->setAttribute(":tabindex", $index);
    }

    /**
     * whether the Dropdown is disabled
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }

    /**
     * content of the Dropdown Menu, usually a <el-dropdown-menu> element
     */
    function setDropdownMenu(callable $callable)
    {
        $ddm = new DropdownMenu;
        $ddm->setAttribute("slot", "dropdown");
        $this->append($ddm);
        $callable($ddm);
    }

    /**
     * triggers when a dropdown item is clicked
     * the command dispatched from the dropdown item
     */
    function onCommand(string $command)
    {
        $this->setAttribute("v-on:command", $command);
    }
}
