<?php

namespace FormKit;

use JsonSerializable;

class FormKit implements JsonSerializable
{
    private $config = [];
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function jsonSerialize()
    {
        return $this->config;
    }
}
