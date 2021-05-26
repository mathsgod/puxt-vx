<?php

namespace VX\UI;

use P\HTMLElement;

class Tabs extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("vx-tabs");
    }

    public function add(string $label, string $uri)
    {
        $tab = new Tab();
        $tab->setAttribute("label", $label);
        $tab->setAttribute("link", $uri);
        $this->append($tab);


        if ($this->firstChild == $tab) {
            $tab->setAttribute("active", true);
        }

        return $tab;
    }
}
