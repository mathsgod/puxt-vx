<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElCountdown extends ComponentNode
{
    function format(string $format)
    {
        $this->setAttribute('format', $format);
        return $this;
    }

    function prefix(string $prefix)
    {
        $this->setAttribute('prefix', $prefix);
        return $this;
    }

    function suffix(string $suffix)
    {
        $this->setAttribute('suffix', $suffix);
        return $this;
    }

    function title(string $title)
    {
        $this->setAttribute('title', $title);
        return $this;
    }

    function valueStyle(string|array $valueStyle)
    {
        $this->setAttribute('value-style', $valueStyle);
        return $this;
    }
}
