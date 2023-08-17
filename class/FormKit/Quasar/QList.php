<?php

namespace FormKit\Quasar;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QList extends ComponentBaseNode
{

    public function separator(bool $sperator = true)
    {
        return $this->setProp("separator", $sperator);
    }

    public function dense(bool $dense = true)
    {
        return $this->setProp("dense", $dense);
    }

    public function addItem(): QItem
    {
        return $this->appendHTML('<q-item></q-item>')[0];
    }


    public function item(?string $label = null, $content = null)
    {
        $item = $this->addItem();
        if ($label) {
            $item->addSection($label);
        }
        if ($content) {

            $item->addSection($content)->side();
        }

        return $this;
    }
}
