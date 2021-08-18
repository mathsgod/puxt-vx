<?php

namespace VX\UI;

use P\HTMLElement;
use VX\User;

class Avatar extends HTMLElement
{

    public function __construct()
    {

        parent::__construct("vx-avatar");
    }

    public function setUser(User $user)
    {
        $this->setAttribute("title", (string)$user);
    }
    
}
