<?php

namespace VX\UI\EL;

use P\CustomEvent;
use P\HTMLElement;
use VX\FileManager;

class FormItem extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("el-form-item");
        $this->scope = "scope.form.";
    }

    public function setScope(string $scope)
    {
        $this->scope = $scope;
    }

    public function upload(string $name)
    {
        $upload = new Upload;
        $upload->setAttribute(":file-list", "scope.form.{$name}");
        $upload->setAttribute("action", "");
        $upload->setAttribute(":auto-upload", "false");
        $upload->setAttribute("name", $name);

        $btn = new Button;
        $btn->textContent = "Select file";
        $upload->append($btn);

        //$upload->append()//
        $this->append($upload);
        $this->setAttribute("prop", $name);

        return $upload;
    }

    public function switch(string $name)
    {
        $s = new _Switch;
        $s->setAttribute("v-model", "scope.form.{$name}");
        $this->append($s);
        $this->setAttribute("prop", $name);
        return $s;
    }

    public function inputNumber(string $name)
    {
        $t = new InputNumber;
        $t->setAttribute("v-model", "scope.form.{$name}");
        $this->append($t);
        $this->setAttribute("prop", $name);
        return $t;
    }

    public function transfer(string $name)
    {
        $t = new Transfer;
        $t->setAttribute("v-model", "scope.form.{$name}");
        $this->append($t);
        $this->setAttribute("prop", $name);
        return $t;
    }

    public function rate(string $name)
    {
        $rate = new Rate;
        $rate->setAttribute("v-model", "scope.form.{$name}");
        $this->append($rate);
        $this->setAttribute("prop", $name);
        return $rate;
    }

    public function timePicker(string $name)
    {
        $timePicker = new TimePicker;
        $timePicker->setAttribute("v-model", "scope.form.{$name}");
        $this->append($timePicker);
        $this->setAttribute("prop", $name);
        return $timePicker;
    }

    public function timeSelect(string $name)
    {
        $timeSelect = new TimeSelect;
        $timeSelect->setAttribute("v-model", "scope.form.{$name}");
        $this->append($timeSelect);
        $this->setAttribute("prop", $name);
        return $timeSelect;
    }

    public function tinymce(string $name)
    {
        $input = new HTMLElement("vx-tinymce");
        $input->setAttribute("v-model", "scope.form.{$name}");
        $input->setAttribute("accept", join(", ", FileManager::LookupMimeType("image")));
        $this->append($input);
        $this->setAttribute("prop", $name);
        return $input;
    }

    public function filemanager(string $name)
    {
        $input = new HTMLElement("vx-file-input");
        $input->setAttribute("v-model", "scope.form.{$name}");
        $this->append($input);
        $this->setAttribute("prop", $name);
        return $input;
    }

    public function required(string $message = null)
    {
        $label = $this->getAttribute("label");

        $rules = json_decode($this->getAttribute(":rules") ?? "[]", true);

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
        $input = new Input;
        $input->setAttribute("name", $name);
        $input->setAttribute("v-model", "scope.form.{$name}");
        $input->setAttribute("type", "textarea");

        $this->append($input);
        $this->setAttribute("prop", $name);
        return $input;
    }

    public function input(string $name)
    {
        $input = new Input;
        $input->setAttribute("name", $name);
        $input->setAttribute("v-model", $this->scope . $name);

        $this->append($input);
        $this->setAttribute("prop", $name);
        return $input;
    }

    public function email(string $name)
    {
        $input = new Input;
        $input->setAttribute("name", $name);
        $input->setAttribute("v-model", $this->scope . $name);

        $this->append($input);
        $this->setAttribute("prop", $name);

        $this->setAttribute(":rules", json_encode([
            [
                "type" => "email"
            ]
        ]));
        return $input;
    }


    public function password(string $name)
    {
        $input = new Input;
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

    public function multiSelect(string $name, $data_source = null, $display_member = null, $value_member = null)
    {
        $select = $this->select($name, $data_source, $display_member, $value_member);;
        $select->setAttribute("multiple", true);
        $select->setAttribute("type", "success");

        $select->style->width = "100%";

        return $select;
    }

    public function select(string $name, $data_source = null, $display_member = null, $value_member = null)
    {
        $select = new Select;
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


        $this->setAttribute("prop", $name);
        return $select;
    }

    public function datePicker(string $name)
    {
        $date = new DatePicker();
        $date->setAttribute("name", $name);
        $date->setAttribute("v-model", "scope.form.{$name}");
        $date->setAttribute("value-format", "yyyy-MM-dd");

        $this->append($date);
        $this->setAttribute("prop", $name);
        return $date;
    }

    public function date(string $name)
    {
        return $this->datePicker($name);
    }

    public function colorPicker(string $name)
    {
        $c = new ColorPicker;
        $c->setAttribute("name", $name);
        $c->setAttribute("v-model", "scope.form.{$name}");

        $this->append($c);
        $this->setAttribute("prop", $name);

        return $c;
    }

    public function dateTimePicker(string $name)
    {
        $dt = new DatePicker;
        $dt->setAttribute("name", $name);
        $dt->setAttribute("v-model", "scope.form.{$name}");
        $dt->setAttribute("value-format", "yyyy-MM-dd HH:mm:ss");
        $dt->setAttribute("type", "datetime");

        $this->append($dt);
        $this->setAttribute("prop", $name);

        return $dt;
    }

    public function checkbox(string $name)
    {
        $cb = new Checkbox;
        $cb->setAttribute("v-model", "scope.form.{$name}");

        $this->append($cb);
        $this->setAttribute("prop", $name);
        return $cb;
    }

    public function helpBlock(string $text)
    {
        $p = new HTMLElement("p");
        $p->classList->add("mb-0");
        $p->textContent = $text;
        $this->append($p);
        return $p;
    }
}
