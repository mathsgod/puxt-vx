<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Time extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('time', [], $translator);
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/time#max
     */
    function max(string $max)
    {
        $this->property['max'] = $max;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/time#min
     */
    function min(string $min)
    {
        $this->property['min'] = $min;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/time#step
     */
    function step(int $step)
    {
        $this->property['step'] = $step;
        return $this;
    }
}
