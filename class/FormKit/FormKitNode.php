<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

// formkit node
// https://formkit.com/essentials/schema#formkit-inputs
class FormKitNode extends SchemaNode
{

    public function __construct(string $formkit, array $property = [], ?TranslatorInterface $translator = null)
    {
        $this->property = array_merge([
            '$formkit' => $formkit
        ], $property);
        parent::__construct($translator);
    }

    /**
     * Preserves the value of the input on a parent group, list, or form when the input unmounts.
     */
    public function preserve(bool $preserve)
    {
        $this->property['preserve'] = $preserve;
        return $this;
    }

    /**
     * Text for help text associated with the input.
     */
    public function help(string $help)
    {
        $this->property['help'] = $help;
        return $this;
    }

    /**
     * The unique id of the input. Providing an id also allows the input’s node to be globally accessed.
     */
    public function id(string $id)
    {
        $this->property['id'] = $id;
        return $this;
    }

    /**
     * Allows an input to be inserted at the given index if the parent is a list. If the input’s value is undefined, it inherits the value from that index position. If it has a value it inserts it into the lists’s values at the given index.
     */
    public function index(int $index)
    {
        $this->property['index'] = $index;
        return $this;
    }

    /**
     * Text for the label element associated with the input.
     */
    public function label(string $label)
    {
        $this->property['label'] = $label;
        if ($this->translator) {
            $this->property['label'] = $this->translator->trans($label);
        }
        return $this;
    }

    /**
     * The name of the input as identified in the data object. This should be unique within a group of fields.
     */
    public function name($value)
    {
        $this->property["name"] = $value;
        return $this;
    }

    /**
     * Specifies an icon to put in the prefixIcon section.
     */
    public function prefixIcon(string $prefixIcon)
    {
        $this->property['prefix-icon'] = $prefixIcon;
        return $this;
    }

    /**
     * Specifies an icon to put in the suffixIcon section.
     */
    public function suffixIcon(string $suffixIcon)
    {
        $this->property['suffix-icon'] = $suffixIcon;
        return $this;
    }

    /**
     * The validation rules to be applied to the input.
     */
    public function validation(string|array $validation)
    {
        $this->property['validation'] = $validation;
        return $this;
    }

    /**
     * Determines when to show an input's failing validation rules. Valid values are blur, dirty, and live.
     */
    public function validationVisibility(string $validationVisibility)
    {
        $this->property['validationVisibility'] = $validationVisibility;
        return $this;
    }

    /**
     * Determines what label to use in validation error messages, by default it uses the label prop if available, otherwise it uses the name prop.
     */
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

    public function options(array $options)
    {
        $this->property['options'] = $options;
        return $this;
    }
}
