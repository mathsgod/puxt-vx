<?php

namespace FormKit;

class Hidden extends SchemaNode
{
    public function __construct()
    {
        $this->property = array_merge([
            '$formkit' => "hidden"
        ]);

        parent::__construct();
    }
}
