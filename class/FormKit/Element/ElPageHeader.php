<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;

class ElPageHeader extends ComponentBaseNode
{
    function icon(string $value)
    {
        $this->setAttribute('icon', $value);
        return $this;
    }

    function title(string $value)
    {
        $this->setAttribute('title', $value);
        return $this;
    }

    function content(string $value)
    {
        $this->setAttribute('content', $value);
        return $this;
    }
}
