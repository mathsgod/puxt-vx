<?php

namespace FormKit;

class VxSchema extends ComponentBaseNode
{
    function src(string $src)
    {
        $this->setAttribute('src', $src);
        return $this;
    }
}
