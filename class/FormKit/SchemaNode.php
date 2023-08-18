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
    use FormKitTrait;



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

        foreach (glob(__DIR__ . "/Element/Inputs/*.php") as $file) {
            $class = basename($file, ".php");
            //to kebab-case
            $kebabCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $class));
            $this->registerInputClass($kebabCase, "FormKit\\Element\\Inputs\\" . $class);
        }

        foreach (glob(__DIR__ . "/Quasar/*.php") as $file) {
            $class = basename($file, ".php");
            //to kebab-case
            $kebabCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $class));
            $this->registerClass($kebabCase, "FormKit\\Quasar\\" . $class);
        }


        $this->registerInputClass("vxForm", VxForm::class);
        $this->registerClass("vx-table", VxTable::class);
        $this->registerClass("vx-table-action-column", VxActionColumn::class);
        $this->registerClass("vx-column", VxColumn::class);

        $this->registerDefaultDOMNodeClass(ElementNode::class);
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
        $elTree = $this->addElTree($name);
        if ($label) {
            $elTree->label($label);
        }
        if ($name) {
            $elTree->name($name);
        }
        $elTree->formItem();
        return $elTree;
    }


    function addHidden(?string $name)
    {
        $hidden = $this->appendHTML("<form-kit type='hidden'></form-kit>")[0];
        if ($name) {
            $hidden->name($name);
        }
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
        $text = $this->appendHTML("<el-text></el-text>")[0];
        if ($label) {
            $text->label($label);
        }
        $text->name($name);
        return $text;
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
        return $this->appendHTML("<form-kit type='submit'></form-kit>")[0];
    }

    function addElForm()
    {
        return $this->appendHTML("<el-form></el-form>")[0];
    }

    function addElFormItem()
    {
        return $this->appendHTML("<el-form-item></el-form-item>")[0];
    }

    function addColor(string $label, string $name)
    {
        $color = $this->append("<form-kit type='color'></form-kit>")[0];
        $color->label($label);
        $color->name($name);
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
        return $this->appendHTML("<form-kit type='group'></form-kit>")[0];
    }

    function addMenu()
    {
        return $this->addElMenu()->router(true)->mode("horizontal");
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

    function addElement(string $el, array $property = []): ElementNode
    {
        $element = $this->appendElement($el);


        foreach ($property as $key => $value) {
            $element->setAttribute($key, $value);
        }

        return $element;
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
        $formkit = $this->appendHTML("<form-kit type='el-slider'></form-kit>")[0];

        $formkit->formItem();

        if ($label) {
            $formkit->label($label);
        }

        return $formkit;
    }

    function addRate(string $label, string $name)
    {
        $formkit = $this->appendHTML("<form-kit type='el-rate'></form-kit>")[0];
        $formkit->formItem();
        $formkit->label($label);
        $formkit->name($name);
        return $formkit;
    }

    function addDateRangePicker(string $label, string $name)
    {
        $formkit = $this->appendHTML("<form-kit type='el-date-picker'></form-kit>")[0];
        $formkit->formItem();
        $formkit->label($label);
        $formkit->name($name);
        return $formkit;
    }

    function addColorPicker(string $label, string $name)
    {
        $formkit = $this->appendHTML("<form-kit type='el-color-picker'></form-kit>")[0];
        $formkit->formItem();
        $formkit->label($label);
        $formkit->name($name);
        return $formkit;
    }


    function addDatePicker(string $label, string $name)
    {
        $formkit = $this->appendHTML("<form-kit type='el-date-picker'></form-kit>")[0];
        $formkit->formItem();
        $formkit->label($label);
        $formkit->name($name);
        return $formkit;
    }

    function addPassword(string $label, string $name)
    {
        $formkit = $this->appendHTML("<form-kit type='el-input'></form-kit>")[0];
        $formkit->formItem();
        $formkit->label($label);
        $formkit->name($name);
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
        $formkit = $this->addElInput($label, $name);
        $formkit->formItem();
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
