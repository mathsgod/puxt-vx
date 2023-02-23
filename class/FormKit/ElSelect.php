<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElSelect extends ElInputNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('el-select', $property, $translator);
    }

    /**
     * whether multiple-select is activated
     */
    function multiple(bool $multiple = true)
    {
        $this->property['multiple'] = $multiple;
        return $this;
    }

    /**
     * whether Select is disabled
     */
    function disabled(bool $disabled = true)
    {
        $this->property['disabled'] = $disabled;
        return $this;
    }

    /**
     * unique identity key name for value, required when value is an object
     */
    function valueKey(string $valueKey)
    {
        $this->property['value-key'] = $valueKey;
        return $this;
    }

    /**
     * size of Input
     */
    function size(string $size)
    {
        $this->property['size'] = $size;
        return $this;
    }

    /**
     * whether select can be cleared
     */
    function clearable(bool $clearable = true)
    {
        $this->property['clearable'] = $clearable;
        return $this;
    }

    /**
     * whether to collapse tags to a text when multiple selecting
     */
    function collapseTags(bool $collapseTags = true)
    {
        $this->property['collapse-tags'] = $collapseTags;
        return $this;
    }

    /**
     * whether show all selected tags when mouse hover text of collapse-tags. To use this, collapse-tags must be true
     */
    function collapseTagsTooltip(bool $collapseTagsTooltip = true)
    {
        $this->property['collapse-tags-tooltip'] = $collapseTagsTooltip;
        return $this;
    }

    /**
     * maximum number of options user can select when multiple is true. No limit when set to 0
     */
    function multipleLimit(int $multipleLimit)
    {
        $this->property['multiple-limit'] = $multipleLimit;
        return $this;
    }

    /**
     * Tooltip theme, built-in theme: dark / light
     */
    function effect(string $effect)
    {
        $this->property['effect'] = $effect;
        return $this;
    }

    /**
     * the autocomplete attribute of select input
     */
    function autocomplete(string $autocomplete)
    {
        $this->property['autocomplete'] = $autocomplete;
        return $this;
    }

    /**
     * placeholder
     */
    function placeholder(string $placeholder)
    {
        $this->property['placeholder'] = $placeholder;
        return $this;
    }

    /**
     * whether Select is filterable
     */
    function filterable(bool $filterable = true)
    {
        $this->property['filterable'] = $filterable;
        return $this;
    }

    /**
     * whether creating new items is allowed. To use this, filterable must be true
     */
    function allowCreate(bool $allowCreate = true)
    {
        $this->property['allow-create'] = $allowCreate;
        return $this;
    }

    /**
     * whether options are loaded from server
     */
    function remote(bool $remote = true)
    {
        $this->property['remote'] = $remote;
        return $this;
    }

    /**
     * in remote search method show suffix icon
     */
    function remoteShowSuffix(bool $remoteShowSuffix = true)
    {
        $this->property['remote-show-suffix'] = $remoteShowSuffix;
        return $this;
    }

    /**
     * whether Select is loading data from server
     */
    function loading(bool $loading = true)
    {
        $this->property['loading'] = $loading;
        return $this;
    }

    /**
     * displayed text while loading data from server
     */
    function loadingText(string $loadingText)
    {
        $this->property['loading-text'] = $loadingText;
        return $this;
    }

    /**
     * displayed text when no data matches the filtering query, you can also use slot empty
     */
    function noMatchText(string $noMatchText)
    {
        $this->property['no-match-text'] = $noMatchText;
        return $this;
    }

    /**
     * displayed text when there is no options, you can also use slot empty
     */
    function noDataText(string $noDataText)
    {
        $this->property['no-data-text'] = $noDataText;
        return $this;
    }

    /**
     * custom class name for Select's dropdown
     */
    function popperClass(string $popperClass)
    {
        $this->property['popper-class'] = $popperClass;
        return $this;
    }

    /**
     * when multiple and filter is true, whether to reserve current keyword after selecting an option
     */
    function reserveKeyword(bool $reserveKeyword = true)
    {
        $this->property['reserve-keyword'] = $reserveKeyword;
        return $this;
    }

    /**
     * select first matching option on enter key. Use with filterable or remote
     */
    function defaultFirstOption(bool $defaultFirstOption = true)
    {
        $this->property['default-first-option'] = $defaultFirstOption;
        return $this;
    }

    /**
     * whether select dropdown is teleported to the body
     */
    function teleported(bool $teleported = true)
    {
        $this->property['teleported'] = $teleported;
        return $this;
    }

    /**
     * when select dropdown is inactive and persistent is false, select dropdown will be destroyed
     */
    function persistent(bool $persistent = true)
    {
        $this->property['persistent'] = $persistent;
        return $this;
    }

    /**
     * for non-filterable Select, this prop decides if the option menu pops up when the input is focused
     */
    function automaticDropdown(bool $automaticDropdown = true)
    {
        $this->property['automatic-dropdown'] = $automaticDropdown;
        return $this;
    }

    /**
     * Custom clear icon component
     */
    function clearIcon(string $clearIcon)
    {
        $this->property['clear-icon'] = $clearIcon;
        return $this;
    }

    /**
     * whether the width of the dropdown is the same as the input
     */
    function fitInputWidth(bool $fitInputWidth = true)
    {
        $this->property['fit-input-width'] = $fitInputWidth;
        return $this;
    }

    /**
     * Custom suffix icon component
     */
    function suffixIcon(string $suffixIcon)
    {
        $this->property['suffix-icon'] = $suffixIcon;
        return $this;
    }

    /**
     * tag type
     */
    function tagType(string $tagType)
    {
        $this->property['tag-type'] = $tagType;
        return $this;
    }

    /**
     * whether to trigger form validation
     */
    function validateEvent(bool $validateEvent = true)
    {
        $this->property['validate-event'] = $validateEvent;
        return $this;
    }

    /**
     * position of dropdown
     */
    function placement(string $placement)
    {
        $this->property['placement'] = $placement;
        return $this;
    }
}
