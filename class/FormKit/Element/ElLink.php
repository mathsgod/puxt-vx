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
        $this->props['type'] = $type;
        return $this;
    }

    public function underline(bool $underline)
    {
        $this->props['underline'] = $underline;
        return $this;
    }

    public function disabled(bool $disabled)
    {
        $this->props['disabled'] = $disabled;
        return $this;
    }

    public function href(string $href)
    {
        $this->props['href'] = $href;
        return $this;
    }

    public function icon(string $icon)
    {
        $this->props['icon'] = $icon;
        return $this;
    }
}
