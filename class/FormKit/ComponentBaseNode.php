<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ComponentBaseNode extends Component
{

    protected $props = [];
    protected $translator;


    public function setClass(string $class)
    {
        $this->setProp('class', $class);
        return $this;
    }


    public function setProp(string $key, $value)
    {
        $this->props[$key] = $value;
        return $this;
    }
}
