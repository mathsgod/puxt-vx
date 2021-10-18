<?php

namespace VX\UI\EL;

use P\HTMLElement;

class DropdownItem extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-dropdown-item");
    }

    /**
     * a command to be dispatched to Dropdown's command callback
     */
    function setCommand(string|int|array $command)
    {
        if (is_string($command)) {
            $this->setAttribute("command", $command);
        } elseif (is_array($command)) {
            $this->setAttribute(":command", json_encode($command, JSON_UNESCAPED_UNICODE));
        } else {
            $this->setAttribute(":command", $command);
        }
    }

    /**
     * whether the item is disabled
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }

    /**
     * whether a divider is displayed
     */
    function setDivided(bool $divided)
    {
        $this->setAttribute("divided", $divided);
    }

    /**
     * icon class name
     */
    function setIcon(string $icon)
    {
        $this->setAttribute("icon", $icon);
    }
}
