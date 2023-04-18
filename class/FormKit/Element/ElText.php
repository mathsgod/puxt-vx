<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElText extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElText', $property, $translator);
    }

    //'primary' | 'success' | 'warning' | 'danger' | 'info'
    function type(string $type)
    {
        $this->props["type"] = $type;
        return $this;
    }

    //'large' | 'default' | 'small'
    function size(string $size)
    {
        $this->props["size"] = $size;
        return $this;
    }

    function truncated(bool $truncated = true)
    {
        $this->props["truncated"] = $truncated;
        return $this;
    }

    //custom element tag
    function tag(string $tag)
    {
        $this->props["tag"] = $tag;
        return $this;
    }
}
