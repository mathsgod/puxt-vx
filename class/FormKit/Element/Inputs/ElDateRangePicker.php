<?php

namespace FormKit\Element\Inputs;

class ElDateRangePicker extends ElInputNode
{
    public function type(string $type)
    {
        $this->setAttribute('type', $type);
        return $this;
    }

    public function format(string $format)
    {
        $this->setAttribute('format', $format);
        return $this;
    }

    public function placeholder(string $placeholder)
    {
        $this->setAttribute('placeholder', $placeholder);
        return $this;
    }

    public function valueFormat(string $valueFormat)
    {
        $this->setAttribute('valueFormat', $valueFormat);
        return $this;
    }

    public function rangeSeparator(string $rangeSeparator)
    {
        $this->setAttribute('rangeSeparator', $rangeSeparator);
        return $this;
    }

    public function startPlaceholder(string $startPlaceholder)
    {
        $this->setAttribute('startPlaceholder', $startPlaceholder);
        return $this;
    }

    public function endPlaceholder(string $endPlaceholder)
    {
        $this->setAttribute('endPlaceholder', $endPlaceholder);
        return $this;
    }

    public function defaultValue(string $defaultValue)
    {
        $this->setAttribute('defaultValue', $defaultValue);
        return $this;
    }
}
