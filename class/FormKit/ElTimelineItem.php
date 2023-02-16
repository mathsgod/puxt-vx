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
        $this->props['timestamp'] = $value;
        return $this;
    }

    public function type(string $value)
    {
        $this->props['type'] = $value;
        return $this;
    }
}
