<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElSteps extends ComponentBaseNode
{

    function addStep()
    {
        return $this->appendHTML('<el-step></el-step>')[0];
    }

    function space(int|string $value)
    {
        $this->attributes['space'] = $value;
        return $this;
    }

    function direction(string $value)
    {
        $this->attributes['direction'] = $value;
        return $this;
    }

    function active(int $value)
    {
        $this->attributes['active'] = $value;
        return $this;
    }

    function processStatus(string $value)
    {
        $this->attributes['process-status'] = $value;
        return $this;
    }

    function finishStatus(string $value)
    {
        $this->attributes['finish-status'] = $value;
        return $this;
    }

    function alignCenter(bool $value = true)
    {
        $this->attributes['align-center'] = $value;
        return $this;
    }

    function simple(bool $value = true)
    {
        $this->attributes['simple'] = $value;
        return $this;
    }
}
