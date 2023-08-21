<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElMenuItem extends ComponentNode
{


    public function route(string $route)
    {
        $this->setAttribute('route', $route);
        return $this;
    }

    public function index(string $index)
    {
        $this->setAttribute('index', $index);
        return $this;
    }

    public function disabled(bool $disabled)
    {
        $this->setAttribute('disabled', $disabled);
        return $this;
    }
}
