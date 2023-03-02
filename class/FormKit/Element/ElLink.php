<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElLink extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElLink', $property, $translator);
    }

    public function type(string $type)
    {
        $this->setProperty('type', $type);
        return $this;
    }

    public function underline(bool $underline)
    {
        $this->setProperty('underline', $underline);
        return $this;
    }

    public function disabled(bool $disabled)
    {
        $this->setProperty('disabled', $disabled);
        return $this;
    }

    public function href(string $href)
    {
        $this->setProperty('href', $href);
        return $this;
    }

    public function icon(string $icon)
    {
        $this->setProperty('icon', $icon);
        return $this;
    }
}
