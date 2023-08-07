<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QList extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('QList', $property, $translator);
    }

    public function separator()
    {
        return $this->setProp("separator", true);
    }

    public function dense()
    {
        return $this->setProp("dense", true);
    }
}
