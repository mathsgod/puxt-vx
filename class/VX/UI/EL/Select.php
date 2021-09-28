<?php

namespace VX\UI\EL;

use P\Element;
use P\HTMLElement;
use Traversable;

class Select extends FormItemElement
{
    public function __construct()
    {
        parent::__construct("el-select");
    }

    public function multiple()
    {
        $this->setMultiple(true);
        return $this;
    }

    public function setMultiple(bool $value)
    {
        if ($value) {
            $this->setAttribute("multiple", true);
        } else {
            $this->removeAttribute("multiple");
        }
    }

    public function setAllowCreate(bool $value)
    {
        if ($value) {
            $this->setAttribute("allow-create", $value);
            $this->setFilterable(true);
        } else {
            $this->remove("allow-create");
        }
    }

    public function setFilterable(bool $value)
    {

        if ($value) {
            $this->setAttribute("filterable", true);
        } else {
            $this->removeAttribute("filterable");
        }
    }


    public function clearable(bool $value = true)
    {
        $this->setClearable($value);
        return $this;
    }

    public function setClearable(bool $value)
    {
        if ($value) {
            $this->setAttribute("clearable", true);
        } else {
            $this->removeAttribute("clearable");
        }
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
