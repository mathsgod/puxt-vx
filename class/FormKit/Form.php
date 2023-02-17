<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Form extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('form', [], $translator);
    }

    /**
     * Disables the form submit button and all the inputs in the form.
     */
    function disabled(bool $disabled = true)
    {
        $this->property['disabled'] = $disabled;
        return $this;
    }

    /**
     * The message that is shown to near the submit button when a user attempts to submit a form, but not all inputs are valid.
     */
    function incompleteMessage(string|bool $incompleteMessage)
    {
        $this->property['incomplete-message'] = $incompleteMessage;
        return $this;
    }

    /**
     * Attributes or props that should be passed to the built-in submit button.
     */
    function submitAttrs(array $submitAttrs)
    {
        $this->property['submit-attrs'] = $submitAttrs;
        return $this;
    }

    /**
     * Async submit handlers automatically disable the form while pending, you can change this by setting this prop to 'live'.
     */
    function submitBehavior(string $submitBehavior)
    {
        $this->property['submit-behavior'] = $submitBehavior;
        return $this;
    }

    /**
     * The label to use on the built-in submit button.
     */
    function submitLabel(string $submitLabel)
    {
        $this->property['submit-label'] = $submitLabel;
        return $this;
    }

    /**
     * Whether or not to include the actions bar at the bottom of the form (ex. you want to remove the submit button and use your own, set this to false).
     */
    function actions(bool $actions = true)
    {
        $this->property['actions'] = $actions;
        return $this;
    }
}
