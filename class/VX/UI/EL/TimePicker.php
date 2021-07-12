<?php


namespace VX\UI\EL;


class TimePicker extends FormItemElement
{

    public function __construct()
    {
        parent::__construct("el-time-picker");
        $this->setAttribute("value-format", "HH:mm:ss");
    }

    public function setValueFormat(string $format)
    {
        $this->setAttribute("value-format", $format);
        return $this;
    }

    public function setArrowControl(bool $value = true)
    {
        if ($value) {
            $this->setAttribute("arrow-control", true);
        } else {
            $this->removeAttribute("arrow-control");
        }
        return $this;
    }

    public function setPlaceholder(string $placeholder)
    {
        $this->setAttribute("placeholder", $placeholder);
        return $this;
    }

    public function setIsRange(bool $value = true)
    {
        if ($value) {
            $this->setAttribute("is-range", true);
        } else {
            $this->removeAttribute("is-range");
        }
        return $this;
    }
}
