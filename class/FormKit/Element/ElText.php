<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElText extends ComponentNode
{
  

    //'primary' | 'success' | 'warning' | 'danger' | 'info'
    function type(string $type)
    {
        $this->attributes["type"] = $type;
        return $this;
    }

    //'large' | 'default' | 'small'
    function size(string $size)
    {
        $this->attributes["size"] = $size;
        return $this;
    }

    function truncated(bool $truncated = true)
    {
        $this->attributes["truncated"] = $truncated;
        return $this;
    }

    //custom element tag
    function tag(string $tag)
    {
        $this->attributes["tag"] = $tag;
        return $this;
    }
}
