<?php

namespace VX\UI;

use P\HTMLElement;
use P\MutationObserver;
use VX;
use VX\TranslatorAwareInterface;
use VX\TranslatorAwareTrait;

class Form extends HTMLElement implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    private $template;
    private $_data;


    protected $vx;

    public function __construct(VX $vx)
    {
        parent::__construct("vx-form");
        $this->setAttribute("v-slot:default", "scope");

        $mu = new MutationObserver(function () {
        });

        $mu->observe($this, [
            "childList" => true,
            "subtree" => true
        ]);

        $this->vx = $vx;
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

    public function setSuccessUrl(string $url)
    {
        $this->setAttribute("success-url", $url);
    }


    public function add(string $label)
    {
        $item = new FormItem($this->vx);
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
