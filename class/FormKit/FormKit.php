<?php

namespace FormKit;

use JsonSerializable;
use Symfony\Contracts\Translation\TranslatorInterface;

class FormKit implements JsonSerializable
{
    private $config = [];
    private $translator;

    public function __construct(array $config = [], ?TranslatorInterface $translator = null)
    {
        $this->config = $config;
        $this->translator = $translator;
    }

    public function jsonSerialize()
    {
        return $this->config;
    }

    public function label(string $label)
    {
        $this->config['label'] = $label;
        if ($this->translator) {
            $this->config['label'] = $this->translator->trans($label);
        }
        return $this;
    }

    public function validation(string $validation)
    {
        $this->config['validation'] = $validation;
        return $this;
    }

    public function options(array $options)
    {
        $this->config['options'] = $options;
        return $this;
    }
}
