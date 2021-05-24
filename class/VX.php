<?php

use VX\UI\RTableResponse;
use PUXT\Context;
use VX\UI\RTable;

class VX extends Context
{

    public function __construct(Context $context)
    {
        foreach ($context as $k => $v) {
            $this->$k = $v;
        }
    }

    public function createRTable()
    {
        $rt = new RTable();
        return $rt;
    }

    public function createRTableResponse()
    {
        return new  RTableResponse($this, $this->query);
    }
}
