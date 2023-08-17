<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElRow extends ComponentBaseNode
{
    public function addCol(): ElCol
    {
        return $this->appendHTML('<el-col></el-col>')[0];
    }

    public function gutter(int $gutter)
    {
        $this->attributes['gutter'] = $gutter;
        return $this;
    }

    public function justify(string $justify)
    {
        $this->attributes['justify'] = $justify;
        return $this;
    }

    public function align(string $align)
    {
        $this->attributes['align'] = $align;
        return $this;
    }

    public function tag(string $tag)
    {
        $this->attributes['tag'] = $tag;
        return $this;
    }
}
