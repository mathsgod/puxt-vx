<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class FormKitNode extends SchemaNode
{

    public function __construct(string $formkit, array $property = [], ?TranslatorInterface $translator = null)
    {
        $this->property = array_merge([
            '$formkit' => $formkit
        ], $property);
        parent::__construct($translator);
    }

    public function id(string $id)
    {
        $this->property['id'] = $id;
        return $this;
    }


    public function label(string $label)
    {
        $this->property['label'] = $label;
        if ($this->translator) {
            $this->property['label'] = $this->translator->trans($label);
        }
        return $this;
    }

    public function validation(string|array $validation)
    {
        $this->property['validation'] = $validation;
        return $this;
    }

    public function validationLabel(string $validationLabel)
    {
        $this->property['validationLabel'] = $validationLabel;
        return $this;
    }

    public function validationMessages(array $validationMessages)
    {
        $this->property['validationMessages'] = $validationMessages;
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
