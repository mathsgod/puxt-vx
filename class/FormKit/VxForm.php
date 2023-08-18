<?php

namespace FormKit;

use FormKit\Element\ElementTrait;
use FormKit\Quasar\QuasarTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

class VxForm extends FormKitInputs
{
    use QuasarTrait;
    use ElementTrait;
    use FormKitTrait;

    public function backOnSuccess(bool $backOnSuccess)
    {
        $this->setAttribute("back-on-success", $backOnSuccess);
        return $this;
    }

    public function value($value)
    {
        $this->setAttribute(":value", json_encode($value, JSON_UNESCAPED_UNICODE));
        return $this;
    }

    public function action(string $action)
    {
        $this->setAttribute("action", $action);
        return $this;
    }

    public function header(string $header)
    {
        $this->setAttribute("header", $header);
        return $this;
    }

    public function showBack(bool $showBack)
    {
        $this->setAttribute("show-back", $showBack);
        return $this;
    }

    public function enctype(string $enctype)
    {
        $this->setAttribute("enctype", $enctype);
        return $this;
    }

    public function labelWidth(string $labelWidth)
    {
        $this->setAttribute("label-width", $labelWidth);
        return $this;
    }

    public function bodyClass(string $bodyClass)
    {
        $this->setAttribute("body-class", $bodyClass);
        return $this;
    }
}
