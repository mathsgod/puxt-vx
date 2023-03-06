<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElStep extends ComponentBaseNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("ElStep", $property, $translator);
    }

    function title(string $value)
    {
        $this->props['title'] = $value;
        return $this;
    }

    function description(string $value)
    {
        $this->props['description'] = $value;
        return $this;
    }

    function icon(string $value)
    {
        $this->props['icon'] = $value;
        return $this;
    }

    function status(string $value)
    {
        $this->props['status'] = $value;
        return $this;
    }
}
