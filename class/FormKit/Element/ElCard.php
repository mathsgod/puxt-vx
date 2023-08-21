<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;


class ElCard extends ComponentNode
{

    public function header(string $header)
    {
        $this->setAttribute('header', $header);
        return $this;
    }

    public function shadow(string $shadow)
    {
        $this->setAttribute('shadow', $shadow);
        return $this;
    }

    public function bodyStyle(array $bodyStyle)
    {
        $this->setAttribute('body-style', $bodyStyle);
        return $this;
    }
}
