<?php

namespace VX\UI;

use P\HTMLElement;
use VX\TranslatorAwareInterface;
use VX\TranslatorAwareTrait;

class Form extends HTMLElement implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    private $template;
    private $_data;

    public function __construct()
    {
        parent::__construct("vx-form");
        $this->setAttribute("v-slot:default", "scope");
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
        $item = new EL\FormItem;
        $this->append($item);

        $item->setLabel($this->translator->trans($label));
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

    public function addDivider(string $content = null)
    {

        $divider = new EL\Divider();
        if ($divider) {
            $divider->textContent = $content;
        }

        $this->append($divider);
        return $divider;
    }

    public function setValue(string $name, $value)
    {
        $data = json_decode($this->getAttribute(":data"), true);
        $data[$name] = $value;
        $this->setAttribute(":data", json_encode($data, JSON_UNESCAPED_UNICODE));
    }
}
