<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QCard extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('QCard', $property, $translator);
    }

    public function flat()
    {
        return $this->setProp("flat", true);
    }

    public function addSection()
    {
        $section = new QCardSection([], $this->translator);
        $this->children[] = $section;
        return $section;
    }
}
