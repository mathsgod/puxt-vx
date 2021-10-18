<?php

namespace VX\UI\EL;

use P\Element;
use P\HTMLElement;
use Traversable;

class Select extends FormItemElement
{
    function __construct()
    {
        parent::__construct("el-select");
    }

    public function multiple()
    {
        $this->setMultiple(true);
        return $this;
    }

    /**
     * whether multiple-select is activated
     */
    function setMultiple(bool $value)
    {
        $this->setAttribute("multiple", $value);
    }

    /**
     * whether creating new items is allowed. To use this, filterable must be true
     */
    function setAllowCreate(bool $value)
    {
        if ($value) {
            $this->setAttribute("allow-create", $value);
            $this->setFilterable(true);
        } else {
            $this->remove("allow-create");
        }
    }

    /**
     * whether Select is disabled
     */
    function setDisabled(bool $disabled)
    {
        $this->setAttribute("disabled", $disabled);
    }

    /**
     * unique identity key name for value, required when value is an object
     */
    function setValueKey(string $value_key)
    {
        $this->setAttribute("value-key", $value_key);
    }

    /**
     * size of Input
     * @param string $size large/small/mini
     */
    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    public function clearable(bool $value = true)
    {
        $this->setClearable($value);
        return $this;
    }

    /**
     * whether select can be cleared
     */
    function setClearable(bool $clearable)
    {
        $this->setAttribute("clearable", $clearable);
    }


    /**
     * whether to collapse tags to a text when multiple selecting
     */
    function setCollapseTags(bool $collapse_tags)
    {
        $this->setAllowCreate("collapse-tags", $collapse_tags);
    }

    /**
     * maximum number of options user can select when multiple is true. No limit when set to 0
     */
    function setMultipleLimit(int $limit)
    {
        $this->setAttribute(":multiple-limit", $limit);
    }

    /**
     * the name attribute of select input
     */
    function setName(string $name)
    {
        $this->setAttribute("name", $name);
    }

    /**
     * the autocomplete attribute of select input
     */
    function setAutocomplete(string $autocomplete)
    {
        $this->setAttribute("autocomplete", $autocomplete);
    }

    /**
     * 	placeholder
     */
    function setPlaceholder(string $placeholder)
    {
        $this->setAttribute("placeholder", $placeholder);
    }

    /**
     * 	whether Select is filterable
     */
    function setFilterable(bool $filterable)
    {
        $this->setAttribute("filterable", $filterable);
    }

    /**
     * whether options are loaded from server
     */
    function setRemote(string $remote)
    {
        $this->setAttribute("remote", $remote);
    }

    /**
     * displayed text while loading data from server
     */
    function setLoadingText(string $text)
    {
        $this->setAttribute("loading-text", $text);
    }

    /**
     * displayed text when no data matches the filtering query, you can also use slot empty
     */
    function setNoMatchText(string $text)
    {
        $this->setAttribute("no-match-text", $text);
    }

    /**
     * displayed text when there is no options, you can also use slot empty
     */
    function setNoDataText(string $text)
    {
        $this->setAttribute("no-data-text", $text);
    }

    /**
     * custom class name for Select's dropdown
     */
    function setPopperClass(string $class)
    {
        $this->setAttribute("popper-class", $class);
    }

    /**
     * when multiple and filter is true, whether to reserve current keyword after selecting an option
     */
    function setReserveKeyword(bool $reserve_keyword)
    {
        $this->setAttribute("reserve-keyword", $reserve_keyword);
    }

    /**
     * select first matching option on enter key. Use with filterable or remote
     */
    function setDefaultFirstOption(bool $default_first_option)
    {
        $this->setAttribute("default-first-option", $default_first_option);
    }

    /**
     * whether to append the popper menu to body. If the positioning of the popper is wrong, you can try to set this prop to false
     */
    function setPopperAppendToBody(bool $popper_append_to_body)
    {
        $this->setAttribute("popper-append-to-body", $popper_append_to_body);
    }

    /**
     * for non-filterable Select, this prop decides if the option menu pops up when the input is focused
     */
    function setAutomaticDropdown(bool $automatic_dropdown)
    {
        $this->setAttribute("automatic-dropdown", $automatic_dropdown);
    }

    //--- EVENT ---

    /**
     * triggers when the selected value changes
     */
    function onChange(string $script)
    {
        $this->setAttribute("v-on:change", $script);
    }

    /**
     * triggers when the dropdown appears/disappears
     */
    function onVisibleChange(string $script)
    {
        $this->setAttribute("v-on:visible-change", $script);
    }

    /**
     * triggers when a tag is removed in multiple mode
     */
    function onRemoveTag(string $script)
    {
        $this->setAttribute("v-on:remove-tag", $script);
    }

    /**
     * triggers when the clear icon is clicked in a clearable Select
     */
    function onClear(string $script)
    {
        $this->setAttribute("v-on:clear", $script);
    }

    /**
     * triggers when Input blurs
     */
    function onBlur(string $script)
    {
        $this->setAttribute("v-on:blur", $script);
    }

    /**
     * triggers when Input focuses
     */
    function onFocus(string $script)
    {
        $this->setAttribute("v-on:focus", $script);
    }

    /**
     * return new added option group
     * @return iterable<OptionGroup> 
     */
    public function addOptionGroup(iterable $groups, ?callable $callback = null)
    {
        $ret = [];
        foreach ($groups as $group) {
            $option_group = new OptionGroup();
            $option_group->setLabel($group["label"]);

            $this->append($option_group);
            if ($callback) {
                $callback($option_group, $group);
            }

            $ret[] = $option_group;
        }

        return $ret;
    }



    /**
     * @deprecated User addOptionGroup
     */
    public function optionGroup(array $groups, string $key, $source, string $label = null, string $value = null)
    {
        if ($source instanceof  Traversable) {
            $source = iterator_to_array($source);
        }

        if ($value === null) {
            if ($formItem = $this->closest("el-form-item")) {
                $value = $formItem->getAttribute("prop");
            }
        }

        $data = [];
        foreach ($groups as $k => $group) {
            $d = [];
            $d["label"] = $group;

            $options = [];
            foreach ($source as $o) {



                if ($o->{$key} == $k) {
                    $options[] = [
                        "value" => var_get($o, $value),
                        "label" => $label === null ? (string)$o : var_get($o, $label)
                    ];
                }
            }
            $d["options"] = $options;


            $data[] = $d;
        }

        $group = new HTMLElement("el-option-group");
        $group->setAttribute("v-for", "group in " . json_encode($data, JSON_UNESCAPED_UNICODE));
        $group->setAttribute(":key", "group.label");
        $group->setAttribute(":label", "group.label");

        $option = new HTMLElement("el-option");;
        $option->setAttribute("v-for", "item in group.options");
        $option->setAttribute(":key", "item.value");
        $option->setAttribute(":value", "item.value");
        $option->setAttribute(":label", "item.label");

        $group->append($option);

        $this->append($group);
        return $group;
    }

    public function option(array|Traversable $source, string $label = "item", string $value = "value")
    {
        $data = [];
        if ($source instanceof Traversable) {
            foreach ($source as $d) {
                $data[] = [
                    "label" => var_get($d, $label),
                    "value" => var_get($d, $value)
                ];
            }
            $label = "item.label";
            $value = "item.value";
        } else {
            $data = $source;
        }

        $option = new Element("el-option");
        $this->append($option);

        $option->setAttribute(":label", $label);
        $option->setAttribute(":value", $value);
        $option->setAttribute(":key", "value");

        $option->setAttribute("v-for", "(item,value) in " . json_encode($data, JSON_UNESCAPED_UNICODE));
        return $option;
    }
}
