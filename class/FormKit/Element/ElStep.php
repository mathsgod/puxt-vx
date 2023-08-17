<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElStep extends ComponentBaseNode
{

    function title(string $value)
    {
        $this->attributes['title'] = $value;
        return $this;
    }

    function description(string $value)
    {
        $this->attributes['description'] = $value;
        return $this;
    }

    function icon(string $value)
    {
        $this->attributes['icon'] = $value;
        return $this;
    }

    function status(string $value)
    {
        $this->attributes['status'] = $value;
        return $this;
    }
}
