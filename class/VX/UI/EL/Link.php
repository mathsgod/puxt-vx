<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Link extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-link");
    }

    /**
     * type
     * @param string $type primary / success / warning / danger / info
     **/
    function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }


    /**
     * whether the component has underline
     */
    function setUnderline(bool $underline)
    {
        $this->setAttribute("underline", $underline);
    }

    /**
     * whether the component is disabled
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }

    /**
     * same as native hyperlink's href
     */
    function setHref(string $href)
    {
        $this->setAttribute("href", $href);
    }

    /**
     * class name of icon
     */
    function setIcon(string $icon)
    {
        $this->setAttribute("icon", $icon);
    }
}
