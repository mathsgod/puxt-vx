<?php

namespace FormKit\Quasar;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QList extends ComponentBaseNode
{

    public function separator(bool $sperator = true)
    {
        $this->setAttribute("separator", $sperator);
        return $this;
    }

    public function dense(bool $dense = true)
    {
        $this->setAttribute("dense", $dense);
        return $this;
    }

    public function addQItem(): QItem
    {
        return $this->appendHTML('<q-item></q-item>')[0];
    }


    public function item(?string $label = null, $content = null)
    {
        $item = $this->addQItem();

        if ($label) {
            $translator = $this->ownerDocument->getTranslator();
            if ($translator instanceof TranslatorInterface) {
                $label = $translator->trans($label);
            }
            $item->addSection($label);
        }
        if ($content) {

            $item->addSection($content)->side();
        }

        return $this;
    }
}
