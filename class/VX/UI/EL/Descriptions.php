<?php

namespace VX\UI\EL;

use P\Element;
use P\HTMLTemplateElement;

class Descriptions extends Element
{
    function __construct()
    {
        parent::__construct("el-descriptions");
    }

    /**
     * with or without border
     */
    function setBorder(bool $border)
    {
        $this->setAttribute("border", $border);
    }

    /**
     * numbers of Descriptions Item in one line
     */
    function setColumn(int $column)
    {
        $this->setAttribute(":column", $column);
    }

    /**
     * direction of list
     * @param string $direction vertical / horizontal
     */
    function setDirection(string $direction)
    {
        $this->setAttribute("direction", $direction);
    }

    /**
     * size of list
     * @param string $size medium / small / mini
     */
    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    /**
     * title text, display on the top left
     */
    function setTitle(string $title)
    {
        $this->setAttribute("title", $title);
    }

    /**
     * extra text, display on the top right
     */
    function setExtra(string $extra)
    {
        $this->setAttribute("extra", $extra);
    }

    /**
     * change default props colon value of Descriptions Item
     */
    function setColon(bool $colon)
    {
        $this->setAttribute("colon", $colon);
    }

    /**
     * custom label class name
     */
    function setLabelClassName(string $class)
    {
        $this->setAttribute("label-class-name", $class);
    }

    /**
     * custom content class name
     */
    function setContentClassName(string $class)
    {
        $this->setAttribute("content-class-name", $class);
    }

    /**
     * custom label style
     */
    function setLabelStyle(array $style)
    {
        $this->setAttribute(":label-style", json_encode($style, JSON_UNESCAPED_UNICODE));
    }

    /**
     * custom content style
     */
    function setContentStyle(array $style)
    {
        $this->setAttribute(":content-style", json_encode($style, JSON_UNESCAPED_UNICODE));
    }


    /**
     * custom title, display on the top left
     */
    function setTitleTemplate(callable $callable)
    {
        //remove old extra template if exist

        foreach ($this->children as $child) {
            if ($child->hasAttribute("v-slot:title")) {
                $child->remove();
            }
        }

        $template = new HTMLTemplateElement();
        $template->setAttribute("v-slot:title", true);
        $this->append($template);
        $callable($template);
    }

    /**
     * custom extra area, display on the top right
     */
    function setExtraTemplate(callable $callable)
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

    public function addItem(string $label)
    {
        $item = new DescriptionsItem;
        $item->setLabel($label);
        $this->append($item);
        return $item;
    }
}
