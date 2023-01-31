<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElRow extends ComponentBaseNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElRow', $property, $translator);
    }

    public function addCol()
    {
        $item = new ElCol([], $this->translator);
        $this->children[] = $item;
        return $item;
    }

    public function gutter(int $gutter)
    {
        $this->setProperty('gutter', $gutter);
        return $this;
    }

    public function justify(string $justify)
    {
        $this->setProperty('justify', $justify);
        return $this;
    }

    public function align(string $align)
    {
        $this->setProperty('align', $align);
        return $this;
    }

    public function tag(string $tag)
    {
        $this->setProperty('tag', $tag);
        return $this;
    }
}
