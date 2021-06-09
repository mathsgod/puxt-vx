<?php

namespace VX\UI;

use P\HTMLElement;

class Form extends HTMLElement
{

    private $template;
    private $_data;

    public function __construct()
    {
        parent::__construct("vx-form");
        $this->template = new HTMLElement("template");
        $this->template->setAttribute("slot-scope", "scope");
        $this->append($this->template);
    }

    public function setAction(string $url = "")
    {
        $this->setAttribute("action", $url);
        return $this;
    }

    public function setData($data)
    {
        $this->_data = $data;
    }


    public function add(string $label)
    {
        $item = new FormItem;
        $this->template->append($item);

        $item->setLabel($label);

        $this->template->append($item);



        $item->addEventListener("prop_added", function ($e) {
            $detail = $e->detail;
            $name = $detail["name"];

            if ($this->_data) {
                $data = json_decode($this->getAttribute(":data"), true);
                $data[$name] = var_get($this->_data, $name);
                $this->setAttribute(":data", json_encode($data, JSON_UNESCAPED_UNICODE));
            }
        });

        return $item;
    }
}
