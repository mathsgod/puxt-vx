<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Select extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('select', [], $translator);
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
     * When defined, FormKit injects a non-selectable hidden option tag as the first value of the list to serve as a placeholder.
     */
    public function placeholder(string $placeholder)
    {
        $this->property['placeholder'] = $placeholder;
        return $this;
    }

    /**
     * Specifies an icon to put in the selectIcon section. Defaults to the down icon.
     */
    public function selectIcon(string $selectIcon)
    {
        $this->property['selectIcon'] = $selectIcon;
        return $this;
    }
}
