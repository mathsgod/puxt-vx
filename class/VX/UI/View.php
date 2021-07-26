<?php

namespace VX\UI;

use Closure;
use P\HTMLElement;

use VX\TranslatorAwareInterface;
use VX\TranslatorAwareTrait;

class View extends HTMLElement implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    public function __construct()
    {
        parent::__construct("vx-view");
    }

    public function addItem(string $label, string $content)
    {
        $item = new ViewItem();
        $item->setTranslator($this->translator);

        $item->setLabel($label);

        $this->appendChild($item);

        $item->setContent($content);

        return $item;
    }

    public function add(string $label, $field)
    {
        $content = "";
        if ($field instanceof Closure) {
            $content = call_user_func($field, $this->data) ?? "";
        } else {
            $content = var_get($this->data, $field) ?? "";
        }

        return $this->addItem($label, $content);
    }

    public function setData($data)
    {
        $this->data = $data;
    }
}
