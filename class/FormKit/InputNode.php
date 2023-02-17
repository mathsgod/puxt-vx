<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class InputNode extends SchemaBaseNode
{
    protected $translator;

    public function __construct(?TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
    }


    public function label(string $label)
    {
        $this->property['label'] = $label;
        if ($this->translator) {
            $this->property['label'] = $this->translator->trans($label);
        }
        return $this;
    }

    public function name($value)
    {
        $this->property["name"] = $value;
        return $this;
    }
}
