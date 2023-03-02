<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;


class ElCard extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElCard', $property, $translator);
    }

    public function header(string $header)
    {
        $this->props['header'] = $header;
        return $this;
    }

    public function shadow(string $shadow)
    {
        $this->props['shadow'] = $shadow;
        return $this;
    }

    public function bodyStyle(array $bodyStyle)
    {
        $this->props['bodyStyle'] = $bodyStyle;
        return $this;
    }
}
