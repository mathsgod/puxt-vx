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
        $this->setAttribute('space', $value);
        return $this;
    }

    function direction(string $value)
    {
        $this->setAttribute('direction', $value);
        return $this;
    }

    function active(int $value)
    {
        $this->setAttribute('active', $value);
        return $this;
    }

    function processStatus(string $value)
    {
        $this->setAttribute('process-status', $value);
        return $this;
    }

    function finishStatus(string $value)
    {
        $this->setAttribute('finish-status', $value);
        return $this;
    }

    function alignCenter(bool $value = true)
    {
        $this->setAttribute('align-center', $value);
        return $this;
    }

    function simple(bool $value = true)
    {
        $this->setAttribute('simple', $value);
        return $this;
    }
}
