<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Textarea extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('textarea', [], $translator);
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/textarea#attr-cols
     */
    function cols(int $cols)
    {
        $this->property['cols'] = $cols;
        return $this;
    }


    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/textarea#attr-maxlength
     */
    function maxlength(int $maxlength)
    {
        $this->property['maxlength'] = $maxlength;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/textarea#attr-minlength
     */
    function minlength(int $minlength)
    {
        $this->property['minlength'] = $minlength;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/textarea#attr-placeholder
     */
    function placeholder(string $placeholder)
    {
        $this->property['placeholder'] = $placeholder;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/textarea#attr-rows
     */
    function rows(int $rows)
    {
        $this->property['rows'] = $rows;
        return $this;
    }
}
