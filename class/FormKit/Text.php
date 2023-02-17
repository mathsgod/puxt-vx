<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Text extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('text', [], $translator);
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/text#maxlength
     */
    public function maxlength(int $maxlength)
    {
        $this->property['maxlength'] = $maxlength;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/text#minlength
     */
    public function minlength(int $minlength)
    {
        $this->property['minlength'] = $minlength;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/text#placeholder
     */
    public function placeholder(string $placeholder)
    {
        $this->property['placeholder'] = $placeholder;
        return $this;
    }
}
