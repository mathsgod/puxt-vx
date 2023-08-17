<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;


class ElFooter extends ComponentNode
{
    function height(string $height)
    {
        $this->setAttribute('height', $height);
        return $this;
    }
}
