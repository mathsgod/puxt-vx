<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElMenuItem extends ComponentNode
{


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
