<?php

namespace VX\UI\EL;

use P\Element;
use P\HTMLTemplateElement;

class Descriptions extends Element
{
    public function __construct()
    {
        parent::__construct("el-descriptions");
    }

    public function setContentClassName(string $class)
    {
        $this->setAttribute("content-class-name", $class);
    }

    public function setLabelClassName(string $class)
    {
        $this->setAttribute("label-class-name", $class);
    }

    /**
     * direction of list
     * vertical / horizontal
     */
    public function setDirection(string $direction)
    {
        $this->setAttribute("direction", $direction);
    }

    public function setTitle(string $title)
    {
        $this->setAttribute("title", $title);
    }

    public function setColumn(int $column)
    {
        $this->setAttribute(":column", $column);
    }

    public function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    public function setBorder(bool $border)
    {
        if ($border) {
            $this->setAttribute("border", true);
        } else {
            $this->removeAttribute("border");
        }
    }

    public function addItem(string $label)
    {
        $item = new DescriptionsItem;
        $item->setLabel($label);
        $this->append($item);
        return $item;
    }

    public function setExtraTemplate(callable $callable)
    {
        //remove old extra template if exist

        foreach ($this->children as $child) {
            if ($child->hasAttribute("v-slot:extra")) {
                $child->remove();
            }
        }

        $template = new HTMLTemplateElement();
        $template->setAttribute("v-slot:extra", true);
        $this->append($template);
        $callable($template);
    }
}
