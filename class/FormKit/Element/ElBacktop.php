<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElBacktop extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElBacktop', $property, $translator);
    }

    function target(string $value)
    {
        $this->props['target'] = $value;
        return $this;
    }

    function visibilityHeight(int $value)
    {
        $this->props['visibility-height'] = $value;
        return $this;
    }

    function right(int $value)
    {
        $this->props['right'] = $value;
        return $this;
    }

    function bottom(int $value)
    {
        $this->props['bottom'] = $value;
        return $this;
    }
}
