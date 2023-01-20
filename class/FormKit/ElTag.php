<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElTag extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElTag', $property, $translator);
    }

    public function type(string $type)
    {
        $this->setProperty('type', $type);
        return $this;
    }

    public function closable(bool $closable)
    {
        $this->setProperty('closable', $closable);
        return $this;
    }
}
