<?php

namespace VX\UI\EL;


class TimeSelect extends FormItemElement
{

    public function __construct()
    {
        parent::__construct("el-time-select");
        $this->setAttribute(":picker-options", json_encode(["start" => '08:30', "step" => "00:15", "end" => "18:30"]));
        $this->setAttribute("value-format", "HH:mm:ss");
    }

    public function setValueFormat(string $format)
    {
        $this->setAttribute("value-format", $format);
        return $this;
    }

    function setStart(string $start)
    {
        $options = json_decode($this->getAttribute(":picker-options"), true);
        $options["start"] = $start;
        $this->setAttribute(":picker-options", json_encode($options));
        return $this;
    }

    function setStep(string $step)
    {
        $options = json_decode($this->getAttribute(":picker-options"), true);
        $options["step"] = $step;
        $this->setAttribute(":picker-options", json_encode($options));
        return $this;
    }

    function setEnd(string $end)
    {
        $options = json_decode($this->getAttribute(":picker-options"), true);
        $options["end"] = $end;
        $this->setAttribute(":picker-options", json_encode($options));
        return $this;
    }
}
