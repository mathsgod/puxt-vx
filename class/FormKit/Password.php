<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Password extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('password', [], $translator);
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/password#maxlength
     */
    function maxLength(int $maxLength)
    {
        $this->property['maxLength'] = $maxLength;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/password#minlength
     */
    function minLength(int $minLength)
    {
        $this->property['minLength'] = $minLength;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/password#placeholder
     */
    function placeholder(string $placeholder)
    {
        $this->property['placeholder'] = $placeholder;
        return $this;
    }
}
