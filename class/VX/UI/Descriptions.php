<?php

namespace VX\UI;

use Closure;
use P\Element;
use Stringable;
use VX\TranslatorAwareInterface;
use VX\TranslatorAwareTrait;

class Descriptions extends EL\Descriptions  implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    public $data;

    public function __construct()
    {
        parent::__construct();
        $this->setColumn(1);
        $this->setLabelClassName("font-weight-bold pr-50 mr-0");
        $this->setContentClassName("px-50");
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function addItem(string $label)
    {
        $item = parent::addItem($this->translator->trans($label));
        return $item;
    }

    public function add(string $label, string|callable $field)
    {
        $item = $this->addItem($label);

        if ($this->data) {
            $content = "";
            if ($field instanceof Closure) {
                $content = $field($this->data) ?? "";
                if($content instanceof Element){
                    
                    
                }elseif ($content instanceof Stringable) {
                    $content = (string)$content;
                }
            } else {
                $content = var_get($this->data, $field) ?? "";

                
                if ($content === true) {
                    $content = "✔";
                }
                if ($content === false) {
                    $content = "";
                }
            }

            if (is_numeric($content)) {
                $content = (string)$content;
            }

            $item->append($content);
        }
        return $item;
    }
}
