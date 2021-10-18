<?php

namespace VX\UI\EL;

use P\Element;
use P\HTMLTemplateElement;

class DescriptionsItem extends Element
{
    function __construct()
    {
        parent::__construct("el-descriptions-item");
    }

    /**
     * label text
     */
    function setLabel(string $label)
    {
        $this->setAttribute("label", $label);
    }

    /**
     * colspan of column
     */
    function setSpan(int $span)
    {
        $this->setAttribute(":span", $span);
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
     * custom label
     */
    public function setLabelTemplate(callable $callable)
    {
        foreach ($this->children as $child) {
            if ($child->hasAttribute("v-slot:label")) {
                $child->remove();
            }
        }

        $template = new HTMLTemplateElement;
        $template->setAttribute("v-slot:label", true);
        $this->append($template);
        $callable($template);
    }
}
