<?php

namespace FormKit;

class VxSchema extends ComponentBaseNode
{

    public function __construct(array $property = [])
    {
        parent::__construct("VxSchema", $property);
    }

    function src(string $src)
    {
        $this->props['src'] = $src;
        return $this;
    }
}
