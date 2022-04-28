<?php

namespace VX\UI\EL;

class DatePicker extends  FormItemElement
{
    const TYPE_YEAR = "year";
    const TYPE_MONTH = "month";
    const TYPE_DATE = "date";
    const TYPE_DATES = "dates";
    const TYPE_DATETIME = "datetime";
    const TYPE_WEEK = "week";
    const TYPE_DATE_RANGE = "daterange";
    const TYPE_DATETIME_RANGE = "datetimerange";
    const TYPE_MONTH_RANGE = "monthrange";

    function __construct()
    {
        parent::__construct("el-date-picker");
    }

    /**
     * whether DatePicker is read only
     */
    function setReadonly(bool $readonly)
    {
        $this->setAttribute("readonly", $readonly);
    }

    /**
     * whether DatePicker is disabled
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }

    /**
     * size of Input
     * @param bool $size large/small/mini
     */
    function setSize(bool $size)
    {
        $this->setAttribute("size", $size);
    }

    /**
     * whether the input is editable
     */
    function setEditable(bool $editable)
    {
        $this->setAttribute(":editable", json_encode($editable));
    }

    /**
     * whether to show clear button
     */
    function clearable(bool $clearable)
    {
        $this->setAttribute(":clearable", json_encode($clearable));
    }

    /**
     * placeholder in non-range mode
     */
    function setPlaceholder(string $placeholder)
    {
        $this->setAttribute("placeholder", $placeholder);
    }

    /**
     * placeholder for the start date in range mode
     */
    function setStartPlaceholder(string $placeholder)
    {
        $this->setAttribute("start-placeholder", $placeholder);
    }

    /**
     * placeholder for the end date in range mode
     */
    function setEndPlaceholder(string $placeholder)
    {
        $this->setAttribute("end-placeholder", $placeholder);
    }

    /**
     * type of the picker
     * @param string $type year/month/date/dates/datetime/week/datetimerange/daterange/monthrange
     */
    function setType(string $type)
    {
        $this->setAttribute("type", $type);
        if ($type == "year" || $type == "month") {
            $this->removeAttribute("value-format");
            $this->removeAttribute("format");
        }
    }

    /**
     * format of the displayed value in the input box
     */
    function setFormat(string $format)
    {
        $this->setAttribute("format", $format);
    }

    /**
     * alignment
     * @param string $align left/center/right
     */
    function setAlign(string $align)
    {
        $this->setAttribute("align", $align);
    }

    /**
     * custom class name for DatePicker's dropdown
     */
    function setPopperClass(string $class)
    {
        $this->setAttribute("popper-class", $class);
    }

    /**
     * range separator
     */
    function setRangeSperator(string $range_sperator)
    {
        $this->setAttribute("range-separator", $range_sperator);
    }

    /**
     * optional, the time value to use when selecting date range
     * @param array<string> $default_time
     */
    function setDefaultTime($default_time)
    {
        $this->setAttribute(":default-time", json_encode($default_time, JSON_UNESCAPED_UNICODE));
    }

    /**
     * optional, format of binding value. If not specified, the binding value will be a Date object
     */
    function setValueFormat(string $format)
    {
        $this->setAttribute("value-format", $format);
    }

    /**
     * same as name in native input
     */
    function setName(string $name)
    {
        $this->setAttribute("name", $name);
    }

    /**
     * unlink two date-panels in range-picker
     */
    function setUnlinkPanels(bool $unlink_panels)
    {
        $this->setAttribute("unlink-panels", $unlink_panels);
    }

    /**
     * Custom prefix icon class
     */
    function setPrefixIcon(string $icon)
    {
        $this->setAttribute("prefix-icon", $icon);
    }

    /**
     * Custom clear icon class
     */
    function setClearIcon(string $icon)
    {
        $this->setAttribute("clear-icon", $icon);
    }

    /**
     * whether to trigger form validation
     */
    function setValidateEvent(bool $validate_event)
    {
        $this->setAttribute("validate-event", $validate_event);
    }
}
