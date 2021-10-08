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

    public function __construct()
    {
        parent::__construct("el-button");
    }

    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }

    function setPlain(bool $plain)
    {
        if ($plain) {
            $this->setAttribute("plain", true);
        } else {
            $this->removeAttribute("plain");
        }
    }

    function setRound(bool $round)
    {
        if ($round) {
            $this->setAttribute("round", true);
        } else {
            $this->removeAttribute("round");
        }
    }

    function setCircle(bool $circle)
    {
        if ($circle) {
            $this->setAttribute("circle", true);
        } else {
            $this->removeAttribute("circle");
        }
    }

    function setLoading(bool $loading)
    {
        if ($loading) {
            $this->setAttribute("loading", true);
        } else {
            $this->removeAttribute("loading");
        }
    }

    function setDisabled(bool $disabled)
    {
        if ($disabled) {
            $this->setAttribute("disabled", true);
        } else {
            $this->removeAttribute("disabled");
        }
    }

    function setIcon(string $icon)
    {
        $this->setAttribute("icon", $icon);
    }
}
