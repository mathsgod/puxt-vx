<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Search extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('search', [], $translator);
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/search#maxlength
     */
    function maxLength(int $maxLength)
    {
        $this->property['maxLength'] = $maxLength;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/search#minlength
     */
    function minLength(int $minLength)
    {
        $this->property['minLength'] = $minLength;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/search#placeholder
     */
    function placeholder(string $placeholder)
    {
        $this->property['placeholder'] = $placeholder;
        return $this;
    }
}
