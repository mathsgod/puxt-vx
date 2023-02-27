<?php

namespace FormKit;

use JsonSerializable;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class SchemaNode extends SchemaBaseNode
{
    protected $translator;

    function __construct(?TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
    }

    //Quasar Components
    function addQIcon(?string $name = null)
    {
        $icon = new QIcon([]);
        if ($name) {
            $icon->name($name);
        }
        $this->children[] = $icon;
        return $icon;
    }

    //Vx Component
    function addVxLink(?string $label, ?string $to)
    {
        $link = new VxLink([], $this->translator);
        if ($label) {
            $link->label($label);
        }

        if ($to) {
            $link->to($to);
        }

        $this->children[] = $link;
        return $link;
    }


    // FormKit Input Components
    function addFKTime(?string $label = null, ?string $name = null)
    {
        $time = new Time($this->translator);
        if ($label) {
            $time->label($label);
        }
        if ($name) {
            $time->name($name);
        }
        $this->children[] = $time;
        return $time;
    }

    function addFKTextarea(?string $label = null, ?string $name = null)
    {
        $textarea = new Textarea($this->translator);
        if ($label) {
            $textarea->label($label);
        }
        if ($name) {
            $textarea->name($name);
        }
        $this->children[] = $textarea;
        return $textarea;
    }

    function addFKTel(?string $label = null, ?string $name = null)
    {
        $tel = new Tel($this->translator);
        if ($label) {
            $tel->label($label);
        }
        if ($name) {
            $tel->name($name);
        }
        $this->children[] = $tel;
        return $tel;
    }

    function addFKSearch(?string $label = null, ?string $name = null)
    {
        $search = new Search($this->translator);
        if ($label) {
            $search->label($label);
        }
        if ($name) {
            $search->name($name);
        }
        $this->children[] = $search;
        return $search;
    }

    function addFKRange(?string $label = null, ?string $name = null)
    {
        $range = new Range($this->translator);
        if ($label) {
            $range->label($label);
        }
        if ($name) {
            $range->name($name);
        }
        $this->children[] = $range;
        return $range;
    }

    function addFKPassword(?string $label = null, ?string $name = null)
    {
        $password = new Password($this->translator);
        if ($label) {
            $password->label($label);
        }
        if ($name) {
            $password->name($name);
        }
        $this->children[] = $password;
        return $password;
    }

    function addFKNumber(?string $label = null, ?string $name = null)
    {
        $number = new Number($this->translator);
        if ($label) {
            $number->label($label);
        }
        if ($name) {
            $number->name($name);
        }
        $this->children[] = $number;
        return $number;
    }

    function addList()
    {
        $list = new FKList();
        $this->children[] = $list;
        return $list;
    }

    function addFKForm()
    {
        $form = new Form($this->translator);
        $this->children[] = $form;
        return $form;
    }

    function addFKDatetimeLocal(?string $label = null, ?string $name = null)
    {
        $date = new DatetimeLocal($this->translator);
        if ($label) {
            $date->label($label);
        }
        if ($name) {
            $date->name($name);
        }
        $this->children[] = $date;
        return $date;
    }

    function addFKDate(?string $label = null, ?string $name = null)
    {
        $date = new Date($this->translator);
        if ($label) {
            $date->label($label);
        }
        if ($name) {
            $date->name($name);
        }
        $this->children[] = $date;
        return $date;
    }

    function addFKCheckbox(?string $label = null, ?string $name = null)
    {
        $checkbox = new Checkbox($this->translator);
        if ($label) {
            $checkbox->label($label);
        }
        if ($name) {
            $checkbox->name($name);
        }
        $this->children[] = $checkbox;
        return $checkbox;
    }

    function addFKFile(?string $label = null, ?string $name = null)
    {
        $file = new File($this->translator);
        if ($label) {
            $file->label($label);
        }
        if ($name) {
            $file->name($name);
        }
        $this->children[] = $file;
        return $file;
    }


    function addFKEmail(?string $label = null, ?string $name = null)
    {
        $email = new Email($this->translator);
        if ($label) {
            $email->label($label);
        }
        if ($name) {
            $email->name($name);
        }
        $this->children[] = $email;
        return $email;
    }

    function addFKRadio(?string $label = null, ?string $name = null)
    {
        $radio = new Radio($this->translator);
        if ($label) {
            $radio->label($label);
        }
        if ($name) {
            $radio->name($name);
        }
        $this->children[] = $radio;
        return $radio;
    }

    function addFKSelect(?string $label = null, ?string $name = null)
    {
        $select = new Select($this->translator);
        if ($label) {
            $select->label($label);
        }
        if ($name) {
            $select->name($name);
        }
        $this->children[] = $select;
        return $select;
    }

    //--------------------------------------------------------------------------------

    function addTree(?string $label = null, ?string $name = null)
    {
        $elTree = new ElTree();
        if ($label) {
            $elTree->label($label);
        }
        if ($name) {
            $elTree->name($name);
        }
        $elTree->formItem();
        $this->children[] = $elTree;
        return $elTree;
    }

    function addElTree()
    {
        $elTree = new ElTree();
        $this->children[] = $elTree;
        return $elTree;
    }

    function addHidden(?string $name)
    {
        $hidden = new Hidden();
        if ($name) {
            $hidden->name($name);
        }
        $this->children[] = $hidden;
        return $hidden;
    }

    function addCollapse()
    {
        $collapse = new ElCollapse([], $this->translator);
        $this->children[] = $collapse;
        return $collapse;
    }

    function addBadge()
    {
        $badge = new ElBadge([], $this->translator);
        $this->children[] = $badge;
        return $badge;
    }

    function addText(?string $label = null, string $name)
    {
        $color = new Text($this->translator);
        if ($label) {
            $color->label($label);
        }


        $color->name($name);
        $this->children[] = $color;
        return $color;
    }

    function addButton(?string $text = null)
    {
        $button = new ElButton([], $this->translator);
        $this->children[] = $button;
        if ($text) {
            $button->addChildren($text);
        }
        return $button;
    }


    function addSubmit()
    {
        $submit = new Submit([], $this->translator);
        $this->children[] = $submit;
        return $submit;
    }

    function addElForm()
    {
        $form = new ElForm([], $this->translator);
        $this->children[] = $form;
        return $form;
    }

    function addElFormItem()
    {
        $item = new ElFormItem([], $this->translator);
        $this->children[] = $item;
        return $item;
    }

    function addColor(string $label, string $name)
    {
        $color = new Color($this->translator);
        if ($label) {
            $color->label($label);
        }


        $color->name($name);
        $this->children[] = $color;
        return $color;
    }

    function addRepeater(string $label, ?string $name = null)
    {
        $repeater = new VxRepeater([], $this->translator);

        if ($label) {
            $repeater->label($label);
        }

        if ($name) {
            $repeater->name($name);
        }
        $this->children[] = $repeater;
        return $repeater;
    }

    function addGroup()
    {
        $group = new Group($this->translator);
        $this->children[] = $group;
        return $group;
    }

    function addMenu()
    {
        return $this->addElMenu()->router(true);
    }

    function addElStatistic()
    {
        $statistic = new ElStatistic([], $this->translator);
        $this->children[] = $statistic;
        return $statistic;
    }

    function addElCountdown()
    {
        $countdown = new ElCountdown([], $this->translator);
        $this->children[] = $countdown;
        return $countdown;
    }

    function addElMenu()
    {
        $menu = new ElMenu([], $this->translator);
        $this->children[] = $menu;
        return $menu;
    }

    function addVxTable()
    {
        $table = new VxTable([], $this->translator);
        $this->children[] = $table;
        return $table;
    }

    function addForm()
    {
        $form = new VxForm([], $this->translator);
        $this->children[] = $form;
        return $form;
    }


    /*     function addFileInput(){
        $fileInput = new FileInput([], $this->translator);
        $this->children[] = $fileInput;
        return $fileInput;
    } */

    /**
     * Append a child node, and return the self object.
     */
    function children(array|string|JsonSerializable $children)
    {
        $this->children[] = $children;
        return $this;
    }


    function property(string $name, $value)
    {
        $this->property[$name] = $value;
        return $this;
    }

    function props(string $props)
    {
        $this->property['props'] = $props;
        return $this;
    }

    function addElement(string $el, array $property = [])
    {
        $item = new ElementNode($el, $property, $this->translator);
        $this->children[] = $item;
        return $item;
    }

    function createComponent(string $cmp, array $property = []): ComponentNode
    {
        return new ComponentNode($cmp, $property);
    }

    function createElement(string $el, array $property = []): ElementNode
    {
        return new ElementNode($el, $property, $this->translator);
    }

    function addComponent(string $cmp, array $props = [])
    {
        $node = new ComponentNode($cmp, $props);
        $this->children[] = $node;
        return $node;
    }

    function addFormKitComponent(string $formkit, array $property = [])
    {
        $node = new FormKitNode($formkit, $property, $this->translator);
        $this->children[] = $node;
        return $node;
    }


    function addResult()
    {
        $result = new ElResult([], $this->translator);
        $this->children[] = $result;
        return $result;
    }

    function addEmpty()
    {
        $empty = new ElEmpty();
        $this->children[] = $empty;
        return $empty;
    }


    function addLink()
    {
        $component = new ElLink([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addRow()
    {
        $component = new ElRow([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addDescriptions()
    {
        return $this->addElDescriptions()->column(1)->border();
    }

    function addElDescriptions()
    {
        $component = new ElDescriptions([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElTable()
    {
        $component = new ElTable([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addTag()
    {
        $component = new ElTag([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addTimeline()
    {
        $component = new ElTimeline([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElCard()
    {
        $component = new ElCard([], $this->translator);

        $this->children[] = $component;
        return $component;
    }

    function addCard(?string $header = null)
    {
        $card = $this->addElCard();
        if ($header) {
            $card->header($header);
        }
        $card->shadow("never");
        return $card;
    }

    function addTinymce(string $label, string $name)
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

    function addUpload(string $label, string $name)
    {
        if ($this instanceof VxForm) {
            $this->enctype("multipart/form-data");
        }

        $formkit = new ElUpload([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addTransfer(string $label, string $name)
    {
        $formkit = new ElTransfer([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addTimePicker(string $label, string $name)
    {
        $formkit = new ElTimePicker([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addTimeSelect(string $label, string $name)
    {
        $formkit = new ElTimeSelect([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addTextarea(string $label, string $name)
    {
        $formkit = new ElTextarea([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addSlider(string $label, string $name)
    {
        $formkit = new ElSlider([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addRate(string $label, string $name)
    {
        $formkit = new ElRate([
            "name" => $name,
        ], $this->translator);
        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addDateRangePicker(string $label, string $name)
    {
        $formkit = new ElDateRangePicker([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addColorPicker(string $label, string $name)
    {
        $formkit = new ElColorPicker([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }


    function addDatePicker(string $label, string $name)
    {
        $formkit = new ElDatePicker([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }
        $this->children[] = $formkit;

        return $formkit;
    }

    function addPassword(string $label, string $name)
    {
        $formkit = new ElPassword([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addSelect(string $label, string $name)
    {
        $formkit = new ElSelect([
            "name" => $name,
        ], $this->translator);
        $formkit->filterable()->clearable();

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addCheckbox(string $label, string $name)
    {
        $formkit = new ElCheckbox([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addElDivider()
    {
        $component = new ElDivider([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addDivider(?string $label = null)
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

    function addElRadioGroup()
    {
        $component = new ElRadioGroup([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addRadioGroup(string $label, string $name)
    {
        $formkit = new ElRadioGroup([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addCheckboxGroup(string $label, string $name)
    {
        $formkit = new ElCheckboxGroup([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addSwitch(string $label, string $name)
    {
        $formkit = new ElSwitch([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addItem(array $item)
    {
        $this->children[] = $item;
    }

    function addCodeInput(string $label, string $name)
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

    function addFileInput(string $label, string $name)
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

    function addInput(string $label, string $name)
    {
        $formkit = new ElInput([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem(true);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addInputNumber(string $label, string $name)
    {
        $formkit = new ElInputNumber([
            "name" => $name,
        ], $this->translator);

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addElInput(?string $label = null, string $name)
    {
        $formkit = new ElInput([
            "name" => $name,
        ], $this->translator);

        if ($label) {
            $formkit->label($label);
        }

        $this->children[] = $formkit;

        return $formkit;
    }

    function addTabs()
    {
        $tabs = $this->addElTabs();
        $tabs->type("border-card");
        return $tabs;
    }

    function addElTabs()
    {
        $component = new ElTabs([], $this->translator);
        $this->children[] = $component;
        return $component;
    }
}
