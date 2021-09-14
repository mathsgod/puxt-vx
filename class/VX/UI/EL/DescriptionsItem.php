<?php

namespace VX\UI\EL;

use P\Element;

class DescriptionsItem extends Element
{

    public function __construct()
    {
        parent::__construct("el-descriptions-item");
    }

    public function setLabel(string $label)
    {
        $this->setAttribute("label", $label);
    }
}
