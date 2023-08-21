<?php

namespace FormKit;

class VxLink extends ComponentNode
{

    function action(string $action)
    {
        $this->setAttribute('action', $action);
        return $this;
    }

    function confirmOptions(array $confirmOptions)
    {
        $this->setAttribute('confirm-options', $confirmOptions);
        return $this;
    }

    function confirmTitle(string $confirmTitle)
    {
        $this->setAttribute('confirm-title', $confirmTitle);
        return $this;
    }

    function confirmMessage(string $confirmMessage)
    {
        $this->setAttribute('confirm-message', $confirmMessage);
        return $this;
    }

    function confirm(bool $confirm = true)
    {
        $this->setAttribute('confirm', $confirm);
        return $this;
    }

    function label(string $label)
    {
        $this->setAttribute('label', $label);
        return $this;
    }

    function to(string $to)
    {
        $this->setAttribute('to', $to);
        return $this;
    }

    function href(string $href)
    {
        $this->setAttribute('href', $href);
        return $this;
    }

    function icon(string $icon)
    {
        $this->setAttribute('icon', $icon);
        return $this;
    }

    function type(string $type)
    {
        $this->setAttribute('type', $type);
        return $this;
    }

    function underline(bool $underline)
    {
        $this->setAttribute('underline', $underline);
        return $this;
    }

    function disabled(bool $disabled)
    {
        $this->setAttribute('disabled', $disabled);
        return $this;
    }
}
