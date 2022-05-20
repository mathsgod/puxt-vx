<?php

namespace VX\UI;

use Closure;
use P\CustomEvent;
use P\HTMLElement;
use VX;
use VX\FileManager;
use VX\UI\EL\_Switch;
use VX\UI\EL\Button;
use VX\UI\EL\Checkbox;
use VX\UI\EL\CheckboxGroup;
use VX\UI\EL\ColorPicker;
use VX\UI\EL\DatePicker;
use VX\UI\EL\Input;
use VX\UI\EL\InputNumber;
use VX\UI\EL\Option;
use VX\UI\EL\Rate;
use VX\UI\EL\Select;
use VX\UI\EL\TimePicker;
use VX\UI\EL\TimeSelect;
use VX\UI\EL\Transfer;
use VX\UI\EL\Upload;

class FormItem extends EL\FormItem
{

    public $scope = "scope.form.";
    protected $_vx;

    public function __construct(VX $vx)
    {
        $this->_vx = $vx;
        parent::__construct();
    }

    function setCol(int $col)
    {
        //remove exists col class
        foreach ($this->classList->values() as $class) {
            if (strstr($class, "col-") !== false) {
                $this->classList->remove($class);
            }
        }
        $this->classList->add("col-12");
        $this->classList->add("col-lg-" . $col);
    }

    function setScope(string $scope)
    {
        $this->scope = $scope;
    }

    function input(string $name)
    {
        $input = new Input;
        $input->setName($name);
        $input->setAttribute("v-model", $this->scope . $name);
        $this->append($input);
        $this->setProp($name);
        return $input;
    }

    function inputNumber(string $name)
    {
        $t = new InputNumber;
        $t->setAttribute("v-model", $this->scope . $name);
        $this->append($t);
        $this->setProp($name);
        return $t;
    }

    function rate(string $name)
    {
        $rate = new Rate;
        $rate->setAttribute("v-model", $this->scope . $name);
        $this->append($rate);
        $this->setProp($name);
        return $rate;
    }

    function timePicker(string $name)
    {
        $timePicker = new TimePicker;
        $timePicker->classList->add("w-100");
        $timePicker->setAttribute("v-model", $this->scope . $name);
        $this->append($timePicker);
        $this->setProp($name);
        return $timePicker;
    }

    function timeSelect(string $name)
    {
        $timeSelect = new TimeSelect;
        $timeSelect->setAttribute("v-model", $this->scope . $name);
        $this->append($timeSelect);
        $this->setProp($name);
        return $timeSelect;
    }

    function switch(string $name)
    {
        $s = new _Switch;
        $s->setAttribute("v-model", $this->scope . $name);
        $this->append($s);
        $this->setProp($name);
        return $s;
    }

    function textarea(string $name)
    {
        $input = new Input;
        $input->setName($name);
        $input->setAttribute("v-model", $this->scope . $name);
        $input->setType("textarea");

        $this->append($input);
        $this->setProp($name);
        return $input;
    }

    function email(string $name)
    {
        $input = new Input;
        $input->setName($name);
        $input->setAttribute("v-model", $this->scope . $name);

        $this->append($input);
        $this->setProp($name);

        $this->setAttribute(":rules", json_encode([
            [
                "type" => "email"
            ]
        ]));
        return $input;
    }

    function password(string $name)
    {
        $input = new Input;
        $input->setName($name);
        $input->setAttribute("v-model", $this->scope . $name);
        $input->setShowPassword(true);

        $this->append($input);
        $this->setProp($name);
        return $input;
    }

    function setAttribute($name, $value)
    {
        if ($name == "prop") {
            $event = new CustomEvent("prop_added", ["detail" => ["name" => $value]]);
            $this->dispatchEvent($event);
        }
        return parent::setAttribute($name, $value);
    }

    function datePicker(string $name)
    {
        $date = new DatePicker();
        $date->classList->add("w-100");
        $date->setName($name);
        $date->setAttribute("v-model", $this->scope . $name);
        $date->setValueFormat("yyyy-MM-dd");

        $this->append($date);
        $this->setProp($name);
        return $date;
    }

    function yearPicker(string $name)
    {
        $date = new DatePicker();
        $date->classList->add("w-100");
        $date->setName($name);
        $date->setAttribute("v-model", $this->scope . $name);
        $date->setType("year");
        $date->setValueFormat("yyyy");
        $this->append($date);
        $this->setProp($name);
        return $date;
    }

    function monthPicker(string $name)
    {
        $date = new DatePicker();
        $date->classList->add("w-100");
        $date->setName($name);
        $date->setAttribute("v-model", $this->scope . $name);
        $date->setType("month");
        $this->append($date);
        $this->setProp($name);
        return $date;
    }

    /**
     * alias for datePicker
     */
    function date(string $name)
    {
        return $this->datePicker($name);
    }

    function colorPicker(string $name)
    {
        $c = new ColorPicker;
        $c->setAttribute("v-model", $this->scope . $name);

        $this->append($c);
        $this->setProp($name);

        return $c;
    }

    function dateTimePicker(string $name)
    {
        $dt = new DatePicker;
        $dt->setName($name);
        $dt->setAttribute("v-model", $this->scope . $name);
        $dt->setValueFormat("yyyy-MM-dd HH:mm:ss");
        $dt->setType("datetime");

        $this->append($dt);
        $this->setProp($name);

        return $dt;
    }

    function checkboxGroup(string $name)
    {
        $group = new CheckboxGroup;
        $group->setAttribute("v-model", $this->scope . $name);

        $this->append($group);
        $this->setProp($name);
        return $group;
    }

    function checkbox(string $name)
    {
        $cb = new Checkbox;
        $cb->setAttribute("v-model", $this->scope . $name);

        $this->append($cb);
        $this->setProp($name);
        return $cb;
    }


    function helpBlock(string $text)
    {
        $p = new HTMLElement("p");
        $p->classList->add("mb-0");
        $p->textContent = $text;
        $this->append($p);
        return $p;
    }


    function select(string $name, $data_source = null, $display_member = null, $value_member = null)
    {
        $select = new Select;
        $select->classList->add("w-100");
        $select->setAttribute("v-model", $this->scope . $name);
        $select->setFilterable(true);
        $select->setClearable(true);
        $this->append($select);


        foreach ($data_source as $r => $v) {
            if (is_string($v)) { //[value=>label]
                $option = new Option;
                if (is_numeric($r)) {
                    $option->setAttribute(":value", $r);
                } else {
                    $option->setAttribute("value", $r);
                }
                $option->setLabel($v);
            } else {
                $option = new Option;
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
                    if ($display_member instanceof Closure) {
                        $label = $display_member($v);
                    } else {
                        $label = var_get($v, $display_member);
                    }
                }
                $option->setLabel($label);
            }

            $select->append($option);
        }


        $this->setProp($name);
        return $select;
    }


    function multiSelect(string $name, $data_source = null, $display_member = null, $value_member = null)
    {
        $select = $this->select($name, $data_source, $display_member, $value_member);;
        $select->setAttribute("multiple", true);
        $select->setAttribute("type", "success");

        $select->style->width = "100%";

        return $select;
    }

    function inputXlsx(string $name, array $schema = [])
    {
        $input = new InputXlsx;
        $input->setAttribute("v-model", $this->scope . $name);
        $this->append($input);
        $this->setProp($name);

        if ($schema) {
            $input->setSchema($schema);
        }
        return $input;
    }

    function required(string $message = null)
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

    function filemanager(string $name)
    {
        $input = new HTMLElement("vx-file-input");
        $input->setAttribute("v-model", $this->scope . $name);
        $this->append($input);
        $this->setProp($name);


        if ($this->_vx->config["VX"]["file_manager_preview"]) {
            $input->setAttribute("preview", "");
        }
        return $input;
    }

    function tinymce(string $name)
    {
        $input = new HTMLElement("vx-tinymce");
        $input->setAttribute("v-model", $this->scope . $name);
        $input->setAttribute("accept", join(", ", FileManager::LookupMimeType("image")));

        if ($this->_vx->config["VX"]["tinymce"]["api-key"]) {
            $input->setAttribute("api-key", $this->_vx->config["VX"]["tinymce"]["api-key"]);
        }
        if ($this->_vx->config["VX"]["tinymce"]["base-url"]) {
            $input->setAttribute("base-url", $this->_vx->config["VX"]["tinymce"]["base-url"]);
        }


        $this->append($input);
        $this->setProp($name);
        return $input;
    }

    function transfer(string $name)
    {
        $t = new Transfer;
        $t->setAttribute("v-model", $this->scope . $name);
        $this->append($t);
        $this->setProp($name);
        return $t;
    }


    function upload(string $name)
    {
        $upload = new Upload;

        $upload->setAttribute(":file-list", $this->scope . $name);
        $upload->setAction("");
        $upload->setAutoUpload(false);
        $upload->setAttribute("name", $name);

        $btn = new Button;
        $btn->textContent = "Select file";
        $upload->append($btn);

        //$upload->append()//
        $this->append($upload);
        $this->setProp($name);

        return $upload;
    }
}
