<?php

namespace FormKit;

use JsonSerializable;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class SchemaNode extends SchemaBaseNode
{
    protected $translator;

    public function __construct(?TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
    }

    public function addMenu()
    {
        $menu = new ElMenu([], $this->translator);
        $this->children[] = $menu;
        return $menu;
    }

    public function addVxTable()
    {
        $table = new VxTable([], $this->translator);
        $this->children[] = $table;
        return $table;
    }

    public function addForm()
    {
        $form = new VxForm([], $this->translator);
        $this->children[] = $form;
        return $form;
    }

    /*     public function addFileInput(){
        $fileInput = new FileInput([], $this->translator);
        $this->children[] = $fileInput;
        return $fileInput;
    } */


    /*   public function children(array|string|JsonSerializable $children)
    {
        $this->children = $children;
        return $this;
    } */

    public function props(array $props)
    {
        $this->property['props'] = $props;
        return $this;
    }

    public function addElement(string $el, array $property = [])
    {
        $item = new ElementNode($el, $property, $this->translator);
        $this->children[] = $item;
        return $item;
    }

    public function createComponent(string $cmp, array $property = []): ComponentNode
    {
        return new ComponentNode($cmp, $property);
    }

    public function addComponent(string $cmp, array $props = [])
    {
        $node = new ComponentNode($cmp, $props);
        $this->children[] = $node;
        return $node;
    }

    public function addFormKitComponent(string $formkit, array $property = [])
    {
        $node = new FormKitNode($formkit, $property, $this->translator);
        $this->children[] = $node;
        return $node;
    }


    public function addChildren(string|JsonSerializable|null $children)
    {
        if ($children === null) {
            return $this;
        }
        $this->children[] = $children;
        return $this;
    }

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

    public function addElTable()
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

    public function addElCard()
    {
        $component = new ElCard([], $this->translator);

        $this->children[] = $component;
        return $component;
    }

    public function addCard()
    {
        $card = $this->addElCard();
        $card->shadow("never");
        return $card;
    }

    public function addTinymce(string $label, string $name)
    {
        $component = new VxFormTinymce([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $component->label($label);
        }
        
        $this->children[] = $component;

        return $component;
    }

    public function addUpload(string $label, string $name)
    {
        if ($this instanceof VxForm) {
            $this->enctype("multipart/form-data");
        }

        $formkit = new ElFormUpload([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addTransfer(string $label, string $name)
    {
        $formkit = new ElFormTransfer([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addTimePicker(string $label, string $name)
    {
        $formkit = new ElFormTimePicker([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addTimeSelect(string $label, string $name)
    {
        $formkit = new ElFormTimeSelect([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addTextarea(string $label, string $name)
    {
        $formkit = new ElFormTextarea([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addSlider(string $label, string $name)
    {
        $formkit = new ElFormSlider([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addRate(string $label, string $name)
    {
        $formkit = new ElFormRate([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addDateRangePicker(string $label, string $name)
    {
        $formkit = new ElFormDateRangePicker([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addColorPicker(string $label, string $name)
    {
        $formkit = new ElFormColorPicker([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }


    public function addDatePicker(string $label, string $name)
    {
        $formkit = new ElFormDatePicker([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }
        $this->children[] = $formkit;

        return $formkit;
    }

    public function addPassword(string $label, string $name)
    {
        $formkit = new ElFormPassword([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addSelect(string $label, string $name)
    {
        $formkit = new ElFormSelect([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addCheckbox(string $label, string $name)
    {
        $formkit = new ElFormCheckbox([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addDivider(?string $label = null)
    {
        $component = new ElDivider([], $this->translator);

        if ($label) {
            if ($this->translator) {
                $label = $this->translator->trans($label);
            }
            $component->addChildren($label);
        }

        $this->children[] = $component;
        return $component;
    }

    public function addRadioGroup(string $label, string $name)
    {
        $formkit = new ElFormRadioGroup([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addSwitch(string $label, string $name)
    {
        $formkit = new ElFormSwitch([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addItem(array $item)
    {
        $this->children[] = $item;
    }

    public function addCodeInput(string $label, string $name)
    {
        $formkit = new VxFormCodeInput([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addFileInput(string $label, string $name)
    {
        $formkit = new VxFormFileInput([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addInput(string $label, string $name)
    {
        $formkit = new ElFormInput([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    public function addInputNumber(string $label, string $name)
    {
        $formkit = new ElFormInputNumber([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }
}
