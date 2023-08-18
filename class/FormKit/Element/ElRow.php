<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElRow extends ComponentNode
{
    public function addCol(): ElCol
    {
        return $this->appendHTML('<el-col></el-col>')[0];
    }

    public function gutter(int $gutter)
    {
        $this->setAttribute('gutter', $gutter);
        return $this;
    }

    public function justify(string $justify)
    {
        $this->setAttribute('justify', $justify);
        return $this;
    }

    public function align(string $align)
    {
        $this->setAttribute('align', $align);
        return $this;
    }

    public function tag(string $tag)
    {
        $this->setAttribute('tag', $tag);
        return $this;
    }
}
