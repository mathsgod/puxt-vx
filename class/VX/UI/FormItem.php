<?php

namespace VX\UI;

use P\CustomEvent;
use P\HTMLElement;

class FormItem extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("el-form-item");
    }

    public function required(string $message = null)
    {
        $label = $this->getAttribute("label");

        $rules[] = [
            "required" => true,
            "message" => $message ?? "$label is required"
        ];
        $this->setAttribute(":rules", json_encode($rules));

        return $this;
    }


    public function setLabel(string $label)
    {
        $this->setAttribute("label", $label);
        return $this;
    }

    public function textarea(string $name)
    {
        $input = new FormItemInput();
        $input->setAttribute("name", $name);
        $input->setAttribute("v-model", "scope.form.{$name}");
        $input->setAttribute("type", "textarea");

        $this->append($input);
        $this->setAttribute("prop", $name);
        return $input;
    }

    public function input(string $name)
    {
        $input = new FormItemInput();
        $input->setAttribute("name", $name);
        $input->setAttribute("v-model", "scope.form.{$name}");

        $this->append($input);
        $this->setAttribute("prop", $name);
        return $input;
    }

    public function password(string $name)
    {
        $input = new FormItemInput();
        $input->setAttribute("name", $name);
        $input->setAttribute("v-model", "scope.form.{$name}");
        $input->setAttribute("show-password", true);

        $this->append($input);
        $this->setAttribute("prop", $name);
        return $input;
    }

    public function setAttribute($name, $value)
    {
        if ($name == "prop") {
            $event = new CustomEvent("prop_added", ["detail" => ["name" => $value]]);
            $this->dispatchEvent($event);
        }
        return parent::setAttribute($name, $value);
    }

    public function select(string $name, $data_source = null, $display_member = null, $value_member = null)
    {
        $select = new FormItemSelect();
        $select->setAttribute("v-model", "scope.form.{$name}");
        $select->setAttribute("filterable", true);
        $select->setAttribute("clearable", true);
        $this->append($select);


        foreach ($data_source as $r => $v) {
            if (is_string($v)) { //[value=>label]

                $option = new HTMLElement("el-option");
                if (is_numeric($r)) {
                    $option->setAttribute(":value", $r);
                } else {
                    $option->setAttribute("value", $r);
                }
                $option->setAttribute("label", $v);
            } else {
                $option = new HTMLElement("el-option");
                if ($value_member === null) {
                    $value_member = $name;
                }
                $value = var_get($v, $value_member);
                if (is_numeric($value)) {
                    $option->setAttribute(":value", $value);
                } else {
                    $option->setAttribute("value", $value);
                }

                if ($display_member === null) {
                    $label = (string)$v;
                } else {
                    $label = var_get($v, $display_member);
                }

                $option->setAttribute("label", $label);
            }

            $select->append($option);
        }


        $hidden = new HTMLElement("input");
        $hidden->setAttribute("type", "hidden");
        $hidden->setAttribute("name", $name);
        $hidden->setAttribute("v-model", "scope.form.$name");
        $this->append($hidden);


        $this->setAttribute("prop", $name);
        return $select;
    }

    public function date(string $name)
    {
        $date = new FormItemDatePicker();
        $date->setAttribute("name", $name);
        $date->setAttribute("v-model", "scope.form.{$name}");
        $date->setAttribute("value-format", "yyyy-MM-dd");

        $this->append($date);
        $this->setAttribute("prop", $name);
        return $date;
    }

    public function checkbox(string $name)
    {
        $cb = new FormItemCheckbox();
        $cb->setAttribute("v-model", "scope.form.{$name}");

        $this->append($cb);
        $this->setAttribute("prop", $name);
        /* 
        $hidden = new HTMLElement("input");
        $hidden->setAttribute("type", "hidden");
        $hidden->setAttribute("name", $name);
        $hidden->setAttribute(":value", "scope.form.$name?1:0");
        $this->append($hidden); */
        return $cb;
    }
}
