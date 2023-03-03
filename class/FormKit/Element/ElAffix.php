<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElAffix extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElAffix', $property, $translator);
    }

    function offset(int $value)
    {
        $this->props['offset'] = $value;
        return $this;
    }

    /**
     * position of affix.
     */
    function position(string $value)
    {
        $this->props['position'] = $value;
        return $this;
    }

    /**
     * 	target container. (CSS selector)
     */
    function target(string $value)
    {
        $this->props['target'] = $value;
        return $this;
    }

    function zIndex(int $value)
    {
        $this->props['z-index'] = $value;
        return $this;
    }
}
