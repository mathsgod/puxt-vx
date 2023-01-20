<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElTableColumn extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElTableColumn', $property, $translator);
    }

    public function label(string $label)
    {
        $this->setProperty('label', $label);
        return $this;
    }

    public function prop(string $prop)
    {
        $this->setProperty('prop', $prop);
        return $this;
    }

    public function sortable(bool $sortable = true)
    {
        $this->setProperty('sortable', $sortable);
        return $this;
    }
}
