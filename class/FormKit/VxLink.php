<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class VxLink extends ComponentNode
{
    public function __construct(array $props = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("VxLink", $props, $translator);
    }

    function label(string $label)
    {
        $this->setProp('label', $label);
        return $this;
    }

    function to(string $to)
    {
        $this->setProp('to', $to);
        return $this;
    }

    function href(string $href)
    {
        $this->setProp('href', $href);
        return $this;
    }

    function icon(string $icon)
    {
        $this->setProp('icon', $icon);
        return $this;
    }

    function type(string $type)
    {
        $this->setProp('type', $type);
        return $this;
    }

    function underline(bool $underline)
    {
        $this->setProp('underline', $underline);
        return $this;
    }

    function disabled(bool $disabled)
    {
        $this->setProp('disabled', $disabled);
        return $this;
    }
}
