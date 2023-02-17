<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Number extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('number', [], $translator);
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/number#min
     */
    function min(int $min)
    {
        $this->property['min'] = $min;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/number#max
     */
    function max(int $max)
    {
        $this->property['max'] = $max;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/number#step
     */
    function step(int $step)
    {
        $this->property['step'] = $step;
        return $this;
    }
}
