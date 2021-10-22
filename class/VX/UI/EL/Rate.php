<?php

namespace VX\UI\EL;

class Rate extends Element
{
    function __construct()
    {
        parent::__construct("el-rate");
    }

    /**
     * max rating score
     */
    function setMax(int $max)
    {
        $this->setAttribute(":max", $max);
    }

    /**
     * whether Rate is read-only
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }

    /**
     * whether picking half start is allowed
     */
    function setAllowHalf(bool $allow_half)
    {
        $this->setAttribute("allow-half", $allow_half);
    }

    /**
     * threshold value between low and medium level. The value itself will be included in low level
     */
    function setLowThreshold(int $threshold)
    {
        $this->setAttribute(":low-threshold", $threshold);
    }

    /**
     * threshold value between medium and high level. The value itself will be included in high level
     */
    function setHighThreshold(int $threshold)
    {
        $this->setAttribute(":high-threshold", $threshold);
    }

    /**
     * colors for icons. If array, it should have 3 elements, each of which corresponds with a score level, else if object, the key should be threshold value between two levels, and the value should be corresponding color
     */
    function setColors(array $colors)
    {
        $this->setAttribute(":colors", json_encode($colors, JSON_UNESCAPED_UNICODE));
    }

    /**
     * color of unselected icons
     */
    function setVoidColor(string $color)
    {
        $this->setAttribute("void-color", $color);
    }

    /**
     * color of unselected read-only icons
     */
    function setDisabledVoidColor(string $color)
    {
        $this->setAttribute("disabled-void-color", $color);
    }

    /**
     * class names of icons. If array, ot should have 3 elements, each of which corresponds with a score level, else if object, the key should be threshold value between two levels, and the value should be corresponding icon class
     */
    function setIconClasses(array $classes)
    {
        $this->setAttribute(":icon-classes", json_encode($classes, JSON_UNESCAPED_UNICODE));
    }

    /** class name of unselected icons */
    function setVoidIconClass(string $class)
    {
        $this->setAttribute("void-icon-class", $class);
    }

    /** class name of unselected read-only icons */
    function setDisabledVoidIconClass(string $class)
    {
        $this->setAttribute("disabled-void-icon-class", $class);
    }

    /** whether to display texts */
    function setShowText(bool $show)
    {
        $this->setAttribute("show-text", $show);
    }

    /** whether to display current score. show-score and show-text cannot be true at the same time */
    function setShowScore(bool $show_score)
    {
        $this->setAttribute("show-score", $show_score);
    }

    /** color of texts */
    function setTextColor(string $color)
    {
        $this->setAttribute("text-color", $color);
    }

    /**	text array */
    function setTexts(array $texts)
    {
        $this->setAttribute(":texts", json_encode($texts, JSON_UNESCAPED_UNICODE));
    }

    /**
     * score template
     */
    function setScoreTemplate(string $template)
    {
        $this->setAttribute("score-template", $template);
    }

    /**
     * Triggers when rate value is changed
     */
    function onChange(string $script)
    {
        $this->setAttribute("v-on:change", $script);
    }
}
