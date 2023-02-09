<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class VxRepeater extends FormKitNode
{

    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("vxRepeater", $property, $translator);
    }

    public function max(int $max)
    {
        $this->property['max'] = $max;
        return $this;
    }

    public function min(int $min)
    {
        $this->property['min'] = $min;
        return $this;
    }
    public function addControl(bool $addButton)
    {
        $this->property['add-button'] = $addButton;
        return $this;
    }

    public function removeControl(bool $removeControl)
    {
        $this->property['remove-button'] = $removeControl;
        return $this;
    }

    public function downControl(bool $downControl)
    {
        $this->property['down-control'] = $downControl;
        return $this;
    }
}
