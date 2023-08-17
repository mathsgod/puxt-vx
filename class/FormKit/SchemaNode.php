<?php

namespace FormKit;
use FormKit\Element\ElementTrait;
use FormKit\Quasar\QuasarTrait;
use JsonSerializable;
use Symfony\Contracts\Translation\TranslatorInterface;

class SchemaNode extends \FormKit\Schema
{
    use QuasarTrait;
    use ElementTrait;



    protected $translator;

    function __construct(?TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
        parent::__construct();
        $this->registerClass("router-link", RouterLink::class);

        foreach (glob(__DIR__ . "/Element/*.php") as $file) {
            $class = basename($file, ".php");
            //to kebab-case
            $kebabCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $class));
            $this->registerClass($kebabCase, "FormKit\\Element\\" . $class);
        }

        foreach (glob(__DIR__ . "/Quasar/*.php") as $file) {
            $class = basename($file, ".php");
            //to kebab-case
            $kebabCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $class));
            $this->registerClass($kebabCase, "FormKit\\Quasar\\" . $class);
        }
    }

    function addRouterLink(): RouterLink
    {
        return $this->appendHTML("<router-link></router-link>")[0];
    }

    //Vx Component
    function addVxLink(?string $label = null, ?string $to = null)
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
        $input = $this->appendHTML("<form-kit type='time'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }
        return $input;
    }

    function addFKTextarea(?string $label = null, ?string $name = null): Inputs\Textarea
    {
        $input = $this->appendHTML("<form-kit type='textarea'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }
        return $input;
    }

    function addFKTel(?string $label = null, ?string $name = null): Inputs\Tel
    {
        $input = $this->appendHTML("<form-kit type='tel'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }
        return $input;
    }

    function addFKSearch(?string $label = null, ?string $name = null): Inputs\Search
    {
        $input = $this->appendHTML("<form-kit type='search'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }
        return $input;
    }

    function addFKRange(?string $label = null, ?string $name = null): Inputs\Range
    {
        $input = $this->appendHTML("<form-kit type='range'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }
        return $input;
    }

    function addFKPassword(?string $label = null, ?string $name = null): Inputs\Password
    {
        $input = $this->appendHTML("<form-kit type='password'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }
        return $input;
    }

    function addFKNumber(?string $label = null, ?string $name = null): Inputs\Number
    {
        $input = $this->appendHTML("<form-kit type='number'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }
        return $input;
    }

    function addList(): Inputs\_List
    {
        $input = $this->appendHTML("<form-kit type='list'></form-kit>")[0];
        return $input;
    }

    function addFKForm(): Inputs\Form
    {
        $input = $this->appendHTML("<form-kit type='form'></form-kit>")[0];
        return $input;
    }

    function addFKDatetimeLocal(?string $label = null, ?string $name = null): Inputs\DatetimeLocal
    {
        $input = $this->appendHTML("<form-kit type='datetime-local'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }
        return $input;
    }

    function addFKDate(?string $label = null, ?string $name = null): Inputs\Date
    {
        $input = $this->appendHTML("<form-kit type='date'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }
        return $input;
    }

    function addFKCheckbox(?string $label = null, ?string $name = null): Inputs\Checkbox
    {
        $input = $this->appendHTML("<form-kit type='checkbox'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }
        return $input;
    }

    function addFKFile(?string $label = null, ?string $name = null): Inputs\File
    {
        $input = $this->appendHTML("<form-kit type='file'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }

        return $input;
    }


    function addFKEmail(?string $label = null, ?string $name = null): Inputs\Email
    {
        $input = $this->appendHTML("<form-kit type='email'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }

        return $input;
    }

    function addFKRadio(?string $label = null, ?string $name = null): Inputs\Radio
    {
        $input = $this->appendHTML("<form-kit type='radio'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }

        return $input;
    }

    function addFKSelect(?string $label = null, ?string $name = null): Inputs\Select
    {
        $input = $this->appendHTML("<form-kit type='select'></form-kit>")[0];
        if ($label) {
            $input->label($label);
        }
        if ($name) {
            $input->name($name);
        }

        return $input;
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

    function addElTree(?string $name)
    {
        $elTree = new ElTree();
        if ($name) {
            $elTree->name($name);
        }
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
        return $this->addElCollapse();
    }

    function addBadge()
    {
        return $this->addElBadge();
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
        $button = $this->addElButton();
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
        return $this->addElMenu()->router(true)->mode("horizontal");
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
        return  $this->addElResult();
    }

    function addEmpty()
    {
        return $this->addElEmpty();
    }

    function addLink()
    {
        return $this->addElLink();
    }

    function addRow()
    {
        return $this->addElRow();
    }

    function addDescriptions()
    {
        return $this->addElDescriptions()->column(1)->border();
    }

    function addLists()
    {
        return $this->addQList()->separator();
    }


    function addTag()
    {
        return $this->addElTag();
    }

    function addTimeline()
    {
        return $this->addElTimeline();
    }

    function addCard(?string $header = null)
    {
        $card = $this->addElCard()->shadow("never");
        if ($header) {
            $card->header($header);
        }
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

    function addDivider(?string $label = null)
    {
        $component = $this->addElDivider();

        if ($label) {
            if ($this->translator) {
                $label = $this->translator->trans($label);
            }
            $component->addChildren($label);
        }

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


    function addVxSchema()
    {
        $component = new VxSchema([], $this->translator);
        $this->children[] = $component;
        return $component;
    }
}
