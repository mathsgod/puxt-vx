<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElStep extends ComponentBaseNode
{

    function title(string $value)
    {
        $this->setAttribute('title', $value);
        return $this;
    }

    function description(string $value)
    {
        $this->setAttribute('description', $value);
        return $this;
    }

    function icon(string $value)
    {
        $this->setAttribute('icon', $value);
        return $this;
    }

    function status(string $value)
    {
        $this->setAttribute('status', $value);
        return $this;
    }
}
