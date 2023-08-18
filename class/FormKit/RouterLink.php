<?php

namespace FormKit;

class RouterLink extends ComponentNode
{

    function to(string $to)
    {
        $this->setAttribute("to", $to);
        return $this;
    }
}
