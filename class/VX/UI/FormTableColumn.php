<?php

namespace VX\UI;

use Element\Button;
use Element\Checkbox;
use Element\DatePicker;
use P\HTMLElement;
use Element\InputNumber;
use Element\Option;
use Element\Select;

class FormTableColumn extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("el-table-column");
    }

    public function width(string $width)
    {
        $this->setAttribute("width", $width);
        return $this;
    }

    private static $FILEMAN_NUM = 0;
    public function fileman(string $name)
    {
        $data_name = $this->parentNode->getAttribute("data-name");

        $this->template = new HTMLElement('template');
        $this->template->setAttribute("slot-scope", "scope");
        $this->append($this->template);

        $fileman = new HTMLElement("fileman");
        $fileman->setAttribute(":name", '`' . $data_name . '[${scope.$index}][' . $name . ']`');
        $fileman->setAttribute("url", "Fileman/?token=");
        $fileman->setAttribute(":id", "`_fileman_" . self::$FILEMAN_NUM . '_${scope.$index}`');
        $fileman->setAttribute("v-model", "scope.row.{$name}");
        self::$FILEMAN_NUM++;
        $this->template->append($fileman);
        return $fileman;
    }



    public function upload(string $name)
    {
        $data_name = $this->parentNode->getAttribute("data-name");

        $this->template = new HTMLElement('template');
        $this->template->setAttribute("slot-scope", "scope");
        $this->append($this->template);


        $upload = new HTMLElement("el-upload");
        $upload->setAttribute(":name", '`' . $data_name . '[${scope.$index}][' . $name . ']`');
        $upload->setAttribute("action", "https://jsonplaceholder.typicode.com/posts/");
        $upload->setAttribute(":limit", 1);
        $upload->setAttribute(":auto-upload", "false");
        $upload->setAttribute(":file-list", "scope.row.$name");


        $button = new Button();
        $button->textContent = "Select file";
        $upload->append($button);
        $this->template->append($upload);


        return $upload;
    }

    public function file(string $name)
    {
        $data_name = $this->parentNode->getAttribute("data-name");

        $this->template = new HTMLElement('template');
        $this->template->setAttribute("slot-scope", "scope");
        $this->append($this->template);


        $input = new HTMLElement("input");
        $input->setAttribute(":name", '`' . $data_name . '[${scope.$index}][' . $name . ']`');
        $input->setAttribute("type", "file");
        $this->template->append($input);


        return $input;
    }

    public function checkbox(string $name)
    {
        $data_name = $this->parentNode->getAttribute("data-name");

        $this->template = new HTMLElement('template');
        $this->template->setAttribute("slot-scope", "scope");
        $this->append($this->template);

        $cb = new Checkbox();
        $cb->setAttribute("v-model", "scope.row.{$name}");
        $this->template->append($cb);

        $hidden = new HTMLElement("input");
        $hidden->setAttribute("type", "hidden");
        $hidden->setAttribute(":name", '`' . $data_name . '[${scope.$index}][' . $name . ']`');
        $hidden->setAttribute(":value", "scope.row.$name?1:0");
        $this->template->append($hidden);
    }

    public function number(string $name)
    {

        $data_name = $this->parentNode->getAttribute("data-name");
        $this->template = new HTMLElement('template');
        $this->template->setAttribute("slot-scope", "scope");
        $input = new InputNumber();
        $input->setAttribute(":name", '`' . $data_name . '[${scope.$index}][' . $name . ']`');
        $input->setAttribute("v-model", "scope.row.{$name}");

        $this->template->append($input);

        $this->append($this->template);
        return $input;
    }

    public function datePicker(string $name)
    {

        $data_name = $this->parentNode->getAttribute("data-name");

        $this->template = new HTMLElement('template');
        $this->template->setAttribute("slot-scope", "scope");
        $date = new DatePicker();
        $date->setAttribute("value-format", "yyyy-MM-dd");
        $date->setAttribute("format", "yyyy-MM-dd");
        $date->setAttribute(":name", '`' . $data_name . '[${scope.$index}][' . $name . ']`');
        $date->setAttribute("v-model", "scope.row.{$name}");

        $this->template->append($date);

        $this->append($this->template);
        return $date;
    }

    public function email(string $name)
    {

        $data_name = $this->parentNode->getAttribute("data-name");
        $this->template = new HTMLElement('template');
        $this->template->setAttribute("slot-scope", "scope");
        $input = new FormTableInput();
        $input->setAttribute("type", "email");
        $input->setAttribute(":name", '`' . $data_name . '[${scope.$index}][' . $name . ']`');
        $input->setAttribute("v-model", "scope.row.{$name}");

        $this->template->append($input);

        $this->append($this->template);
        return $input;
    }

    public function textarea(string $name)
    {
        $data_name = $this->parentNode->getAttribute("data-name");
        $this->template = new HTMLElement('template');
        $this->template->setAttribute("slot-scope", "scope");
        $input = new FormTableInput();
        $input->setAttribute("type", "textarea");
        $input->setAttribute(":name", '`' . $data_name . '[${scope.$index}][' . $name . ']`');
        $input->setAttribute("v-model", "scope.row.{$name}");

        $this->template->append($input);

        $this->append($this->template);
    }


    public function input(string $name)
    {
        $data_name = $this->parentNode->getAttribute("data-name");
        $this->template = new HTMLElement('template');
        $this->template->setAttribute("slot-scope", "scope");
        $input = new FormTableInput();
        $input->setAttribute("size","small");
        $input->setAttribute(":name", '`' . $data_name . '[${scope.$index}][' . $name . ']`');
        $input->setAttribute("v-model", "scope.row.{$name}");

        $this->template->append($input);

        $this->append($this->template);
        return $input;
    }

    public function select(string $name, $source)
    {
        $data_name = $this->parentNode->getAttribute("data-name");
        $this->template = new HTMLElement('template');
        $this->template->setAttribute("slot-scope", "scope");
        $this->append($this->template);

        $select = new Select();
        $select->setAttribute("clearable", true);
        $select->setAttribute("filterable", true);
        $select->setAttribute("v-model", "scope.row.{$name}");
        $this->template->append($select);


        $option = new Option();

        $data = [];
        if ($source) {
            foreach ($source as $k => $v) {
                $data[] = [
                    "label" => $v,
                    "value" => $k
                ];
            }
            $option->setAttribute(":label", "item.label");
            $option->setAttribute(":value", "item.value");
            $option->setAttribute(":key", "value");
            $option->setAttribute("v-for", "(item,value) in " . json_encode($data, JSON_UNESCAPED_UNICODE));

            $select->append($option);
        }



        $hidden = new HTMLElement("input");
        $hidden->setAttribute("type", "hidden");
        $hidden->setAttribute(":name", '`' . $data_name . '[${scope.$index}][' . $name . ']`');
        $hidden->setAttribute("v-model", "scope.row.$name");
        $this->template->append($hidden);


        return $select;
    }
}
