<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;


class ElFooter extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElFooter', $property, $translator);
    }

    function height(string $height)
    {
        $this->props['height'] = $height;
        return $this;
    }
}
