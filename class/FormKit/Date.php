<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Date extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('date', [], $translator);
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/date#min
     */
    public function min(string $min)
    {
        $this->property['min'] = $min;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/date#max
     */
    public function max(string $max)
    {
        $this->property['max'] = $max;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/date#step
     */
    public function step(int $step)
    {
        $this->property['step'] = $step;
        return $this;
    }
}
