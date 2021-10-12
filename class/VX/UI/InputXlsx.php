<?php

namespace VX\UI;

use P\HTMLElement;

class InputXlsx extends HTMLElement
{

    function __construct()
    {
        parent::__construct("vx-input-xlsx");
    }

    function setSchema(array $schema)
    {
        $this->setAttribute(":schema", json_encode($schema, JSON_UNESCAPED_UNICODE));
    }
}
