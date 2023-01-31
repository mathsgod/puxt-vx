<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElMenuItem extends ComponentBaseNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("ElMenuItem", $property, $translator);
    }

    public function route(string $route)
    {
        $this->setProp('route', $route);
        return $this;
    }

    public function index(string $index)
    {
        $this->setProp('index', $index);
        return $this;
    }

    public function disabled(bool $disabled)
    {
        $this->setProp('disabled', $disabled);
        return $this;
    }
}
