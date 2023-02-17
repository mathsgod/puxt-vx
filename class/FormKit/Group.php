<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Group extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('group', [], $translator);
    }

    /**
     * Disables all the inputs in the group.
     */
    public function disabled(bool $disabled = true)
    {
        $this->property['disabled'] = $disabled;
        return $this;
    }
}
