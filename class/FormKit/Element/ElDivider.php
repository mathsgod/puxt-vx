<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElDivider extends ComponentBaseNode
{


    public function contentPosition(string $contentPosition)
    {
        $this->setProp('content-position', $contentPosition);
        return $this;
    }

    public function direction(string $direction)
    {
        $this->setProp('direction', $direction);
        return $this;
    }

    public function borderStyle(string $borderStyle)
    {
        $this->setProp('border-style', $borderStyle);
        return $this;
    }
}
