<?php

namespace FormKit;

use JsonSerializable;
use Symfony\Contracts\Translation\TranslatorInterface;

class Component implements JsonSerializable
{
    public $config = [];
    public $translator;

    public function __construct(array $config = [], ?TranslatorInterface $translator = null)
    {
        $this->config = $config;
        $this->translator = $translator;
    }

    public function jsonSerialize()
    {
        return $this->config;
    }

    public function props(array $props)
    {
        $this->config['props'] = $props;
        return $this;
    }

    public function children(array|string $children)
    {
        $this->config['children'] = $children;
        return $this;
    }
}
