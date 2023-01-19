<?php

namespace FormKit;

use JsonSerializable;

use Symfony\Contracts\Translation\TranslatorInterface;

class Schema implements JsonSerializable
{
    private $translator;
    public function __construct(TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
    }

    private $items = [];

    public function addDivider(?string $label = null)
    {
        $component = new Component([
            '$cmp' => 'elDivider'
        ], $this->translator);

        if ($label) {
            $component->children($label);
        }

        $this->items[] = $component;


        return $component;
    }

    public function addRadioGroup(string $name)
    {
        $formkit = new FormKit([
            '$formkit' => 'elFormRadioGroup',
            "name" => $name,
        ], $this->translator);

        $this->items[] = $formkit;

        return $formkit;
    }

    public function addSwitch(string $name)
    {
        $formkit = new FormKit([
            '$formkit' => 'elFormSwitch',
            "name" => $name,
        ], $this->translator);

        $this->items[] = $formkit;

        return $formkit;
    }

    public function addItem(array $item)
    {
        $this->items[] = $item;
    }

    public function addInput(string $name)
    {
        $formkit = new FormKit([
            '$formkit' => 'elFormInput',
            "name" => $name,
        ], $this->translator);

        $this->items[] = $formkit;

        return $formkit;
    }


    public function addElement(string $el, array $config = [])
    {
        $item = [
            '$el' => $el
        ];
        $item = array_merge($item, $config);
        $this->items[] = $item;
    }

    public function addComponent(string $cmp, array $config = [])
    {
        $item = [
            '$cmp' => $cmp
        ];
        $item = array_merge($item, $config);
        $this->items[] = $item;
    }

    public function addFormKit(string $formkit, array $config = [])
    {
        $item = [
            '$formkit' => $formkit,
        ];
        $item = array_merge($item, $config);
        $this->items[] = $item;
    }

    public function jsonSerialize()
    {
        return $this->items;
    }
}
