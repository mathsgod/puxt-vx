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

    public function __construct()
    {
        parent::__construct("el-date-picker");
    }

    public function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }
}
