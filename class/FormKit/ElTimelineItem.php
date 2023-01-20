<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElTimelineItem extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElTimelineItem', $property, $translator);
    }

    public function timestamp($value)
    {
        return $this->setProperty('timestamp', $value);
    }
}
