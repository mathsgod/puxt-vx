<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Checkbox extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('checkbox', [], $translator);
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

    /**
     * The value when the checkbox is checked (single checkboxes only).
     */
    public function onValue($onValue)
    {
        $this->property['onValue'] = $onValue;
        return $this;
    }

    /**
     * The value when the checkbox is unchecked (single checkboxes only).
     */
    public function offValue($offValue)
    {
        $this->property['offValue'] = $offValue;
        return $this;
    }
}
