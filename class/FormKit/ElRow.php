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
        $this->props['gutter'] = $gutter;
        return $this;
    }

    public function justify(string $justify)
    {
        $this->props['justify'] = $justify;
        return $this;
    }

    public function align(string $align)
    {
        $this->props['align'] = $align;
        return $this;
    }

    public function tag(string $tag)
    {
        $this->props['tag'] = $tag;
        return $this;
    }
}
