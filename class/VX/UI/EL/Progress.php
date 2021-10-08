<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Progress extends HTMLElement
{
    const TYPE_DASHBOARD = "dashboard";
    const TYPE_LINE = "line";
    const TYPE_CIRCLE = "circle";

    const STATUS_SUCCESS = "success";
    const STATUS_EXCEPTION = "exception";
    const STATUS_WARNING = "warning";

    function __construct()
    {
        parent::__construct("el-progress");
    }

    /**
     * @var int $percentage 0-100
     */
    function setPercentage(int $percentage)
    {
        $this->setAttribute(":percentage", $percentage);
    }

    /**
     * line/circle/dashboard
     */
    function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }

    function setStrokeWidth(int $width)
    {
        $this->setAttribute(":stroke-width", $width);
    }

    /**
     * success/exception/warning
     */
    function setStatus(string $status)
    {
        $this->setAttribute("status", $status);
    }

    function setWidth(int $width)
    {
        $this->setAttribute(":width", $width);
    }

    function setShowText(bool $show)
    {
        $this->setAttribute("show-text", $show);
    }

    function setTextInside(bool $inside){
        $this->setAttribute("text-inside", $inside);
    }
}
