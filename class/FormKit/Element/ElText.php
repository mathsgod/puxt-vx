<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElText extends ComponentNode
{


    //'primary' | 'success' | 'warning' | 'danger' | 'info'
    function type(string $type)
    {
        $this->setAttribute("type", $type);
        return $this;
    }

    //'large' | 'default' | 'small'
    function size(string $size)
    {
        $this->setAttribute("size", $size);
        return $this;
    }

    function truncated(bool $truncated = true)
    {
        $this->setAttribute("truncated", $truncated);
        return $this;
    }

    //custom element tag
    function tag(string $tag)
    {
        $this->setAttribute("tag", $tag);
        return $this;
    }
}
