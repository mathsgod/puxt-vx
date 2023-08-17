<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElPageHeader extends ComponentBaseNode
{
    function icon(string $value)
    {
        $this->attributes['icon'] = $value;
        return $this;
    }

    function title(string $value)
    {
        $this->attributes['title'] = $value;
        return $this;
    }

    function content(string $value)
    {
        $this->attributes['content'] = $value;
        return $this;
    }
}
