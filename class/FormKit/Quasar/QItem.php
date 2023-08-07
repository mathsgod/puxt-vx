<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QItem extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('QItem', $property, $translator);
    }

    public function addSection(string $string)
    {
        $section = new QItemSection([], $this->translator);
        $section->addChildren($string);
        $this->children[] = $section;
        return $section;
    }
}
