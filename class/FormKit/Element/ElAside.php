<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;


class ElAside extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElAside', $property, $translator);
    }

    function width(string $width)
    {
        $this->props['width'] = $width;
        return $this;
    }
}
