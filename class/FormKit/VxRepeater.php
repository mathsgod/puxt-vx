<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class VxRepeater extends FormKitInputs
{

    public function max(int $max)
    {
        $this->setAttribute(':max', json_encode($max));
        return $this;
    }

    public function min(int $min)
    {
        $this->setAttribute(':min', json_encode($min));
        return $this;
    }

    public function addControl(bool $addButton)
    {
        if ($addButton) {
            $this->setAttribute('add-button', '');
        } else {
            $this->removeAttribute('add-button');
        }

        return $this;
    }

    public function removeControl(bool $removeControl)
    {
        if ($removeControl) {
            $this->setAttribute('remove-button', '');
        } else {
            $this->removeAttribute('remove-button');
        }

        return $this;
    }

    public function downControl(bool $downControl)
    {
        if ($downControl) {
            $this->setAttribute('down-control', '');
        } else {
            $this->removeAttribute('down-control');
        }
    }
}
