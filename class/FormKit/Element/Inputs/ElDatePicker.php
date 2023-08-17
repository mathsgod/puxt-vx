<?php

namespace FormKit\Element\Inputs;

class ElDatePicker extends ElInputNode
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

    public function defaultTime(string $defaultTime)
    {
        $this->setAttribute('defaultTime', $defaultTime);
        return $this;
    }

    public function editable(bool $editable)
    {
        $this->setAttribute('editable', $editable);
        return $this;
    }

    public function clearable(bool $clearable)
    {
        $this->setAttribute('clearable', $clearable);
        return $this;
    }

    public function size(string $size)
    {
        $this->setAttribute('size', $size);
        return $this;
    }

    public function popperClass(string $popperClass)
    {
        $this->setAttribute('popperClass', $popperClass);
        return $this;
    }

    public function pickerOptions(array $pickerOptions)
    {
        $this->setAttribute(':pickerOptions', json_encode($pickerOptions));
        return $this;
    }

    public function align(string $align)
    {
        $this->setAttribute('align', $align);
        return $this;
    }
}
