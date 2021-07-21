<?php

namespace VX\UI;

use P\HTMLElement;
use VX\UI\EL\DatePicker;
use VX\UI\EL\Form;
use VX\UI\EL\FormItem;
use VX\UI\EL\Input;

class TableSearch extends HTMLElement
{
    public $form;

    public function __construct()
    {

        parent::__construct("template");
        $this->form = new HTMLElement("el-form");
        $this->form->setAttribute(":size", "table.size");
        $this->form->setAttribute(":inline", "true");
        $this->form->setAttribute("v-on:submit.native.prevent", true);
        $this->form->classList->add("ml-2 mr-2");

        $this->append($this->form);
    }

    public function addInput(string $label, string $prop)
    {
        $this->form->append($formItem = new HTMLElement("el-form-item"));
        $formItem->append($input = new Input());
        $formItem->setAttribute("label", $label);

        $input->setAttribute("v-model", "table.search.$prop");
        $input->setAttribute("v-on:keyup.enter.native", 'table.onSearch');
        $input->setAttribute("v-on:clear","table.onSearch");
        $input->setAttribute("clearable", true);


        return $input;
    }

    public function addDate(string $label, string $prop)
    {

        $this->form->append($formItem = new HTMLElement("el-form-item"));
        $formItem->append($date = new DatePicker());
        $formItem->setAttribute("label", $label);

        $date->setAttribute("v-model", "table.search.$prop");
        $date->setType(DatePicker::TYPE_DATE_RANGE);
        $date->setAttribute("value-format", "yyyy-MM-dd");
        $date->setAttribute("v-on:change", "table.onSearch");

        return $date;
    }

    public function addSelect(string $label, string $prop)
    {
        $item = new FormItem;
        $item->setLabel($label);

        //$input = $item->input($prop);
        $input = $item->select($prop, [1 => "A", 2 => "B"]);
        $input->setAttribute("v-on:change", 'table.onSearch');

        $this->append($item);
    }
}
