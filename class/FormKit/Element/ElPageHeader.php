<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElPageHeader extends ComponentBaseNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("ElPageHeader", $property, $translator);
    }

    function icon(string $value)
    {
        $this->props['icon'] = $value;
        return $this;
    }

    function title(string $value)
    {
        $this->props['title'] = $value;
        return $this;
    }

    function content(string $value)
    {
        $this->props['content'] = $value;
        return $this;
    }
}
