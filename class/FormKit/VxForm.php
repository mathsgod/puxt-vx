<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class VxForm extends FormKitNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("vxForm", $property, $translator);
    }

    public function backOnSuccess(bool $backOnSuccess)
    {
        $this->setProperty("back-on-success", $backOnSuccess);
        return $this;
    }

    public function value($value)
    {
        $this->setProperty("value", $value);
        return $this;
    }

    public function action(string $action)
    {
        $this->setProperty("action", $action);
        return $this;
    }

    public function header(string $header)
    {
        $this->setProperty("header", $header);
        return $this;
    }

    public function showBack(bool $showBack)
    {
        $this->setProperty("show-back", $showBack);
        return $this;
    }

    public function enctype(string $enctype)
    {
        $this->setProperty("enctype", $enctype);
        return $this;
    }

    public function labelWidth(string $labelWidth)
    {
        $this->setProperty("label-width", $labelWidth);
        return $this;
    }

    public function bodyClass(string $bodyClass)
    {
        $this->setProperty("body-class", $bodyClass);
        return $this;
    }
}
