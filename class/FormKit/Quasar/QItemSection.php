<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QItemSection extends ComponentNode
{

    public function side()
    {
        return $this->setProp("side", true);
    }
}
