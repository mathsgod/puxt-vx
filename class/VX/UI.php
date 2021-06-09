<?php

namespace VX;

class UI
{

    public function createT($data)
    {

        $t = new UI\T;
        $t->setData($data);

        return $t;
    }
}
