<?php

namespace VX\UI\EL;

class _Switch extends Element
{
    public function __construct()
    {
        parent::__construct("el-switch");
    }

    public function setActiveText(string $text)
    {
        $this->setAttribute("active-text", $text);
        return $this;
    }

    public function setInactiveText(string $text)
    {
        $this->setAttribute("inactive-text", $text);
        return $this;
    }

    public function setActiveColor(string $color)
    {
        $this->setAttribute("active-color", $color);
        return $this;
    }

    public function setInactiveColor(string $color)
    {
        $this->setAttribute("inactive-color", $color);
        return $this;
    }

    public function setActiveValue(bool|string|int $value)
    {
        if (is_string($value)) {
            $this->setAttribute("active-value", $value);
        } elseif (is_bool($value)) {
            $this->setAttribute(":active-value", $value ? "true" : "false");
        } else {
            $this->setAttribute(":active-value", $value);
        }
        return $this;
    }

    public function setInactiveValue(bool|string|int $value)
    {
        if (is_string($value)) {
            $this->setAttribute("inactive-value", $value);
        } elseif (is_bool($value)) {
            $this->setAttribute(":inactive-value", $value ? "true" : "false");
        } else {
            $this->setAttribute(":inactive-value", $value);
        }
        return $this;
    }

    public function disabled()
    {
        $this->setAttribute("disabled", true);
        return $this;
    }
}
