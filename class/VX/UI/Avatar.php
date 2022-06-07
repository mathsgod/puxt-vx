<?php

namespace VX\UI;

use P\HTMLElement;
use VX\User;

class Avatar extends HTMLElement
{

    public function __construct()
    {
        parent::__construct("q-avatar");
        $this->setAttribute("color", "primary");
        $this->setAttribute("text-color", "white");
        $this->setAttribute("size", "md");
    }

    public function setUser(User $user)
    {
        $this->innerText = "test";
        //$this->setAttribute("title", (string)$user);
    }
}
