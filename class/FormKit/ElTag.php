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
        $this->setProp('type', $type);
        return $this;
    }

    public function closable(bool $closable)
    {
        $this->setProp('closable', $closable);
        return $this;
    }
}
