<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Button extends HTMLElement
{
    const SIZE_MINI = "mini";
    const SIZE_SMALL = "small";
    const SIZE_MEDIUM = "medium";
    const SIZE_LARGE = "large";

    const TYPE_PRIMARY = "primary";
    const TYPE_SUCCESS = "success";
    const TYPE_WARNING = "warning";
    const TYPE_DANGER = "danger";
    const TYPE_INFO = "info";
    const TYPE_TEXT = "text";

    function __construct()
    {
        parent::__construct("el-button");
    }

    /**
     * button size
     * @param string $size medium / small / mini
     */
    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    /**
     * button type
     * @param string $type primary / success / warning / danger / info / text
     */
    function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }

    /**
     * determine whether it's a plain button
     */
    function setPlain(bool $plain)
    {
        $this->setAttribute("plain", $plain);
    }

    /**
     * determine whether it's a round button
     */
    function setRound(bool $round)
    {
        $this->setAttribute("round", $round);
    }

    /**
     * determine whether it's a circle button
     */
    function setCircle(bool $circle)
    {
        $this->setAttribute("circle", $circle);
    }

    /**
     * determine whether it's loading
     */
    function setLoading(bool $loading)
    {
        $this->setAttribute("loading", $loading);
    }

    /**
     * disable the button
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }

    /**
     * icon class name
     */
    function setIcon(string $icon)
    {
        $this->setAttribute("icon", $icon);
    }

    /**
     * same as native button's autofocus
     */
    function setAutofocus(bool $autofocus)
    {
        $this->setAttribute("autofocus", $autofocus);
    }

    /**
     * same as native button's type
     * @param string $type button / submit / reset
     */
    function setNativeType(string $type)
    {
        $this->setAttribute("native-type", $type);
    }
}
