<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElCountdown extends ComponentNode
{
    function format(string $format)
    {
        $this->setProp('format', $format);
        return $this;
    }

    function prefix(string $prefix)
    {
        $this->setProp('prefix', $prefix);
        return $this;
    }

    function suffix(string $suffix)
    {
        $this->setProp('suffix', $suffix);
        return $this;
    }

    function title(string $title)
    {
        $this->setProp('title', $title);
        return $this;
    }

    function valueStyle(string|array $valueStyle)
    {
        $this->setProp('value-style', $valueStyle);
        return $this;
    }
}
