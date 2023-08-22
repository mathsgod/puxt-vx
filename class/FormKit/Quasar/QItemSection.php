<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QItemSection extends ComponentNode
{

    public function side()
    {
        $this->setAttribute("side", true);
        return $this;
    }

    public function addItemLabel(): QItemLabel
    {
        return $this->appendHTML('<q-item-label></q-item-label>')[0];
    }

    public function label(string $label)
    {
        $this->addItemLabel()->appendHTML($label);
        return $this;
    }

    public function caption(string $caption)
    {
        $this->addItemLabel()->caption()->appendHTML($caption);

        return $this;
    }
}
