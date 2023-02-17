<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class FKList extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('list', [], $translator);
    }

    /**
     * Disables all the inputs in the list.
     */
    function disabled(bool $disabled = true)
    {
        $this->property['disabled'] = $disabled;
        return $this;
    }
}
