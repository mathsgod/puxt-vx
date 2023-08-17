<?php

namespace FormKit\Quasar;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QList extends ComponentBaseNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('QList', $property, $translator);
    }

    public function separator(bool $sperator = true)
    {
        return $this->setProp("separator", $sperator);
    }

    public function dense(bool $dense = true)
    {
        return $this->setProp("dense", $dense);
    }

    public function addItem()
    {
        $item = new QItem([], $this->translator);
        $this->children[] = $item;
        return $item;
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
