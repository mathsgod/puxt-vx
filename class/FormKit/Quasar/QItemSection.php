<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QItemSection extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('QItemSection', $property, $translator);
    }

    public function side()
    {
        return $this->setProp("side", true);
    }

   
}
