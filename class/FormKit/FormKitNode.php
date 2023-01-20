<?php

namespace FormKit;

use JsonSerializable;

class FormKitNode extends SchemaNode
{

    public function addLink()
    {
        $component = new ElLink([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    public function addRow()
    {
        $component = new ElRow([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    public function addDescriptions()
    {
        $component = new ElDescriptions([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    public function addTable()
    {
        $component = new ElTable([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    public function addTag()
    {
        $component = new ElTag([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    public function addTimeline()
    {
        $component = new ElTimeline([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    public function addCard()
    {
        $component = new ElCard([], $this->translator);
        $this->children[] = $component;
        return $component;
    }




    public function addUpload(string $name)
    {
        $formkit = new ElFormUpload([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addTransfer(string $name)
    {
        $formkit = new ElFormTransfer([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addTimePicker(string $name)
    {
        $formkit = new ElFormTimePicker([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addTimeSelect(string $name)
    {
        $formkit = new ElFormTimeSelect([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addTextarea(string $name)
    {
        $formkit = new ElFormTextarea([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addSlider(string $name)
    {
        $formkit = new ElFormSlider([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addRate(string $name)
    {
        $formkit = new ElFormRate([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addDateRangePicker(string $name)
    {
        $formkit = new ElFormDateRangePicker([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addColorPicker(string $name)
    {
        $formkit = new ElFormColorPicker([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }


    public function addDatePicker(string $name)
    {
        $formkit = new ElFormDatePicker([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addPassword(string $name)
    {
        $formkit = new ElFormPassword([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addSelect(string $name)
    {
        $formkit = new ElFormSelect([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addCheckbox(string $name)
    {
        $formkit = new ElFormCheckbox([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addDivider(?string $label = null)
    {
        $component = new ComponentNode("elDivider", [], $this->translator);

        if ($label) {
            $component->children($label);
        }

        $this->children[] = $component;
        return $component;
    }

    public function addRadioGroup(string $name)
    {
        $formkit = new ElFormRadioGroup([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addSwitch(string $name)
    {
        $formkit = new ElFormSwitch([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addItem(array $item)
    {
        $this->children[] = $item;
    }

    public function addInput(string $name)
    {
        $formkit = new ElFormInput([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addInputNumber(string $name)
    {
        $formkit = new ElFormInputNumber([
            "name" => $name,
        ], $this->translator);

        $this->children[] = $formkit;

        return $formkit;
    }
}
