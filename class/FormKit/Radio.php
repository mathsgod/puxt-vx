<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Radio extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('radio', [], $translator);
    }

    /**
     * Specifies an icon to put in the decoratorIcon section. Shows when the radio is checked. Defaults to the radioDecorator icon.
     */
    public function decoratorIcon(string $decoratorIcon)
    {
        $this->property['decoratorIcon'] = $decoratorIcon;
        return $this;
    }

    /**
     * An object of value/label pairs or an array of strings, or an array of objects that must contain a label and value property.
     */
    public function options(array $options)
    {
        $this->property['options'] = $options;
        return $this;
    }
}
