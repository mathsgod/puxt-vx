<?php

namespace VX\UI\EL;

use P\HTMLElement;
use P\HTMLTemplateElement;

class Alert extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-alert");
    }

    /**
     * title
     */
    function setTitle(string $title)
    {
        $this->setAttribute("title", $title);
    }

    /**
     * Component type
     */
    function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }

    /**
     * Descriptive text. Can also be passed with the default slot
     */
    function setDescription(string $description)
    {
        $this->setAttribute("description", $description);
    }

    /**
     * If closable or not
     */
    function setClosable(bool $closable)
    {
        $this->setAttribute(":closable", json_encode($closable));
    }

    /**
     * Whether to center the text
     */
    function setCenter(bool $center)
    {
        $this->setAttribute(":center", json_encode($center));
    }

    /**
     * Customized close button text
     */
    function setCloseText(string $text)
    {
        $this->setAttribute("close-text", $text);
    }

    /**
     * If a type icon is displayed
     */
    function setShowIcon(bool $show)
    {
        $this->setAttribute("show-icon", $show);
    }

    /**
     * Choose theme
     * @param string $effect light/dark
     */
    function setEffect(string $effect)
    {
        $this->setAttribute("effect", $effect);
    }

    /**
     * content of the Alert title
     */
    function setTitleSlot(callable $callable)
    {
        $template = new HTMLTemplateElement;
        $template->setAttribute("slot", "title");
        $this->append($template);
        $callable($template);
    }
}
