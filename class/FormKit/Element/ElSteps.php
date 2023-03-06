<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElSteps extends ComponentBaseNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("ElSteps", $property, $translator);
    }

    function addStep()
    {
        $component = new ElStep([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function space(int|string $value)
    {
        $this->props['space'] = $value;
        return $this;
    }

    function direction(string $value)
    {
        $this->props['direction'] = $value;
        return $this;
    }

    function active(int $value)
    {
        $this->props['active'] = $value;
        return $this;
    }

    function processStatus(string $value)
    {
        $this->props['process-status'] = $value;
        return $this;
    }

    function finishStatus(string $value)
    {
        $this->props['finish-status'] = $value;
        return $this;
    }

    function alignCenter(bool $value = true)
    {
        $this->props['align-center'] = $value;
        return $this;
    }

    function simple(bool $value = true)
    {
        $this->props['simple'] = $value;
        return $this;
    }
}
