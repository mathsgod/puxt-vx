<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormDatePicker extends FormKitComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormDatePicker', $property, $translator);
    }

    public function type(string $type)
    {
        $this->property['type'] = $type;
        return $this;
    }

    public function format(string $format)
    {
        $this->property['format'] = $format;
        return $this;
    }

    public function placeholder(string $placeholder)
    {
        $this->property['placeholder'] = $placeholder;
        return $this;
    }

    public function valueFormat(string $valueFormat)
    {
        $this->property['valueFormat'] = $valueFormat;
        return $this;
    }

    public function rangeSeparator(string $rangeSeparator)
    {
        $this->property['rangeSeparator'] = $rangeSeparator;
        return $this;
    }

    public function startPlaceholder(string $startPlaceholder)
    {
        $this->property['startPlaceholder'] = $startPlaceholder;
        return $this;
    }

    public function endPlaceholder(string $endPlaceholder)
    {
        $this->property['endPlaceholder'] = $endPlaceholder;
        return $this;
    }

    public function defaultValue(string $defaultValue)
    {
        $this->property['defaultValue'] = $defaultValue;
        return $this;
    }

    public function defaultTime(string $defaultTime)
    {
        $this->property['defaultTime'] = $defaultTime;
        return $this;
    }

    public function editable(bool $editable)
    {
        $this->property['editable'] = $editable;
        return $this;
    }

    public function clearable(bool $clearable)
    {
        $this->property['clearable'] = $clearable;
        return $this;
    }

    public function size(string $size)
    {
        $this->property['size'] = $size;
        return $this;
    }

    public function popperClass(string $popperClass)
    {
        $this->property['popperClass'] = $popperClass;
        return $this;
    }

    public function pickerOptions(array $pickerOptions)
    {
        $this->property['pickerOptions'] = $pickerOptions;
        return $this;
    }

    public function align(string $align)
    {
        $this->property['align'] = $align;
        return $this;
    }
}
