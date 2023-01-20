<?php

namespace FormKit;

use JsonSerializable;
use Symfony\Contracts\Translation\TranslatorInterface;

class FormKitNode implements JsonSerializable
{
    protected $property = [];
    private $translator;

    public function __construct(string $formkit, array $property = [], ?TranslatorInterface $translator = null)
    {
        $this->property = $property;
        $this->property['$formkit'] = $formkit;
        $this->translator = $translator;
    }

    public function jsonSerialize()
    {
        return $this->property;
    }

    public function label(string $label)
    {
        $this->property['label'] = $label;
        if ($this->translator) {
            $this->property['label'] = $this->translator->trans($label);
        }
        return $this;
    }

    public function validation(string $validation)
    {
        $this->property['validation'] = $validation;
        return $this;
    }

    public function validationLabel(string $validationLabel)
    {
        $this->property['validationLabel'] = $validationLabel;
        return $this;
    }

    public function help(string $help)
    {
        $this->property['help'] = $help;
        return $this;
    }

    public function options(array $options)
    {
        $this->property['options'] = $options;
        return $this;
    }
    public function placeholder(string $placeholder)
    {
        $this->property['placeholder'] = $placeholder;
        return $this;
    }

    public function children(array|string $children)
    {
        $this->property['children'] = $children;
        return $this;
    }
}
