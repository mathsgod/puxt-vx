<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElCountdown extends ComponentNode
{
    public function __construct(array $props = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("ElCountdown", $props, $translator);
    }

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
