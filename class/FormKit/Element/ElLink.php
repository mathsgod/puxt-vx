<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElLink extends ComponentNode
{
    public function type(string $type)
    {
        $this->setAttribute('type', $type);

        return $this;
    }

    public function underline(bool $underline)
    {
        if ($underline) {
            $this->setAttribute('underline', '');
        } else {
            $this->removeAttribute('underline');
        };
        return $this;
    }

    public function disabled(bool $disabled)
    {
        if ($disabled) {
            $this->setAttribute('disabled', '');
        } else {
            $this->removeAttribute('disabled');
        };
        return $this;
    }

    public function href(string $href)
    {

        $this->setAttribute('href', $href);

        return $this;
    }

    public function icon(string $icon)
    {
        $this->setAttribute('icon', $icon);
        return $this;
    }
}
