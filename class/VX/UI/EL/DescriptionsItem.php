<?php

namespace VX\UI\EL;

use P\Element;
use P\HTMLTemplateElement;

class DescriptionsItem extends Element
{

    public function __construct()
    {
        parent::__construct("el-descriptions-item");
    }

    public function setLabel(string $label)
    {
        $this->setAttribute("label", $label);
    }

    /**
     * colspan of column
     */
    public function setSpan(int $span)
    {
        $this->setAttribute(":span", $span);
    }


    public function setContentClassName(string $class)
    {
        $this->setAttribute("content-class-name", $class);
    }

    public function setLabelClassName(string $class)
    {
        $this->setAttribute("label-class-name", $class);
    }

    public function setLabelTemplate(callable $callable)
    {
        $template = new HTMLTemplateElement;
        $template->setAttribute("slot", "label");
        $this->append($template);
        $callable($template);
    }
}
