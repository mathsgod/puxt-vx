<?php

namespace VX\UI\EL;

use P\HTMLElement;

class Transfer extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("el-transfer");
    }

    public function setData(array $data)
    {
        $this->setAttribute(":data", json_encode($data));
        return $this;
    }

    public function filterable()
    {
        $this->setAttribute("filterable", true);
        return $this;
    }

    public function setTitles(array $titles)
    {
        $this->setAttribute(":titles", json_encode($titles));
        return $this;
    }
}
