<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElFormDateRangePicker extends FormKitComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('elFormDateRangePicker', $property, $translator);
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
}
