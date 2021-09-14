<?php

namespace VX\UI;

use P\HTMLElement;
use P\HTMLTemplateElement;

class Template extends HTMLTemplateElement
{

    public function addRouterLink(string $to, string $text)
    {
        $link = new HTMLElement("router-link");
        $link->setAttribute(":to", $to);
        $link->setAttribute("v-text", $text);

        $this->append($link);
        return $link;
    }
}
