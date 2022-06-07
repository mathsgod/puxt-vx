<?php

namespace VX\UI;

use P\HTMLElement;

class Tabs extends HTMLElement
{
    const TYPE_TABS = "tabs";
    const TYPE_PILLS = "pills";


    public function __construct()
    {
        parent::__construct("vx-tabs");
    }

    public function add(string $label, string $uri)
    {

        $link = "";
        if ($uri[0] == "/") {
            $link = $uri;
        } else {
            $link = $this->base_url .  "/" . $uri;
        }

        $tab = new Tab();
        $tab->setAttribute("name", $label);
        $tab->setAttribute("label", $label);
        $tab->setAttribute("link", $link);
        $this->appendChild($tab);

        if ($this->firstChild === $tab) {
            $tab->setAttribute("active", true);
        }

        return $tab;
    }

    public function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }

    public function setBaseURL(string $url)
    {
        $this->base_url = $url;
    }
}
