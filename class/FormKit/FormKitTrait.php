<?php

namespace FormKit;

use FormKit\Element\ElementTrait;
use FormKit\Element\ElMenu;
use FormKit\Element\ElTimeline;
use FormKit\Element\Inputs\ElCheckbox;
use FormKit\Element\Inputs\ElCheckboxGroup;
use FormKit\Element\Inputs\ElDatePicker;
use FormKit\Element\Inputs\ElDateRangePicker;
use FormKit\Element\Inputs\ElInput;
use FormKit\Element\Inputs\ElPassword;
use FormKit\Element\Inputs\ElRadioGroup;
use FormKit\Element\Inputs\ElRate;
use FormKit\Element\Inputs\ElSelect;
use FormKit\Element\Inputs\ElSlider;
use FormKit\Element\Inputs\ElTextarea;
use FormKit\Element\Inputs\ElTimePicker;
use FormKit\Element\Inputs\ElTransfer;
use FormKit\Element\Inputs\ElUpload;
use FormKit\Inputs\Group;
use FormKit\Quasar\QuasarTrait;

trait FormKitTrait
{
    use ElementTrait;
    use QuasarTrait;

    function addButton(?string $text = null)
    {
        $button = $this->addElButton();
        if ($text) {
            $button->addChildren($text);
        }
        return $button;
    }


    function addFileInput(string $label, string $name): VxFormFileInput
    {
        $formkit = $this->appendHTML("<form-kit type='FormFileInput'></form-kit>")[0];
        $formkit->label($label);
        $formkit->name($name);
        return $formkit;
    }

    function addTinymce(string $label, string $name): VxFormTinymce
    {
        return $this->appendHTML("<form-kit type='FormTinymce'></form-kit>")[0]->label($label)->name($name);
    }

    function addCodeInput(string $label, string $name): VxFormCodeInput
    {
        $formkit = $this->appendHTML("<form-kit type='FormCodeInput'></form-kit>")[0];
        $formkit->label($label);
        $formkit->name($name);

        return $formkit;
    }

    function addCheckboxGroup(string $label, string $name): ElCheckboxGroup
    {
        $formkit = $this->appendHTML("<form-kit type='el-checkbox-group'></form-kit>")[0];
        $formkit->formItem();
        $formkit->name($name);
        $formkit->label($label);
        return $formkit;
    }

    function addRadioGroup(string $label, string $name): ElRadioGroup
    {
        $formkit = $this->appendHTML("<form-kit type='el-radio-group'></form-kit>")[0];
        $formkit->formItem();
        $formkit->name($name);
        $formkit->label($label);
        return $formkit;
    }


    function addElRadioGroup(): ElRadioGroup
    {
        return $this->appendHTML("<form-kit type='el-radio-group'></form-kit>")[0];
    }


    function addCheckbox(string $label, string $name): ElCheckbox
    {
        $formkit = $this->appendHTML("<form-kit type='el-checkbox'></form-kit>")[0];
        $formkit->formItem();
        $formkit->name($name);
        $formkit->label($label);
        return $formkit;
    }


    function addSlider(string $label, string $name): ElSlider
    {
        $formkit = $this->appendHTML("<form-kit type='el-slider'></form-kit>")[0];
        $formkit->formItem();
        $formkit->label($label);
        $formkit->name($name);
        return $formkit;
    }


    function addTextarea(string $label, string $name): ElTextarea
    {
        $formkit = $this->appendHTML("<form-kit type='el-textarea'></form-kit>")[0];
        $formkit->formItem();
        $formkit->label($label);
        $formkit->name($name);
        return $formkit;
    }

    function addTimeSelect(string $label, string $name): ElTimeline
    {
        $formkit = $this->appendHTML("<form-kit type='el-time-select'></form-kit>")[0];
        $formkit->formItem();
        $formkit->label($label);
        $formkit->name($name);
        return $formkit;
    }

    function addTimePicker(string $label, string $name): ElTimePicker
    {
        $formkit = $this->appendHTML("<form-kit type='el-time-picker'></form-kit>")[0];
        $formkit->formItem();
        $formkit->label($label);
        $formkit->name($name);
        return $formkit;
    }

    function addTransfer(string $label, string $name): ElTransfer
    {
        $formkit = $this->appendHTML("<form-kit type='el-transfer'></form-kit>")[0];
        $formkit->formItem();
        $formkit->name($name);
        $formkit->label($label);
        return $formkit;
    }


    function addUpload(string $label, string $name): ElUpload
    {
        if ($this instanceof VxForm) {
            $this->enctype("multipart/form-data");
        }

        $formkit = $this->appendHTML("<form-kit type='el-upload'></form-kit>")[0];
        $formkit->formItem();
        $formkit->name($name);
        $formkit->label($label);

        return $formkit;
    }


    function addInputNumber(string $label, string $name)
    {

        $formkit = $this->appendHTML("<form-kit type='el-input-number'></form-kit>")[0];
        $formkit->name($name);
        $formkit->formItem();
        $formkit->label($label);
        return $formkit;
    }


    function addElement(string $el, array $property = []): ElementNode
    {
        $element = $this->appendElement($el);

        foreach ($property as $key => $value) {
            $element->setAttribute($key, $value);
        }

        return $element;
    }

    function addSwitch(string $label, string $name)
    {
        $formkit = $this->appendHTML("<form-kit type='el-switch'></form-kit>")[0];
        $formkit->formItem();
        $formkit->name($name);

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
            $component->appendHTML($label);
        }

        return $component;
    }


    function addVxTable(): VxTable
    {
        return $this->appendHTML("<vx-table></vx-table>")[0];
    }

    function addForm(): VxForm
    {
        return $this->appendHTML("<form-kit type='vxForm'></form-kit>")[0];
    }



    function addRate(string $label, string $name): ElRate
    {
        $formkit = $this->appendHTML("<form-kit type='el-rate'></form-kit>")[0];
        $formkit->formItem();
        $formkit->label($label);
        $formkit->name($name);
        return $formkit;
    }

    function addDateRangePicker(string $label, string $name): ElDateRangePicker
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


    function addDatePicker(string $label, string $name): ElDatePicker
    {
        $formkit = $this->appendHTML("<form-kit type='el-date-picker'></form-kit>")[0];
        $formkit->formItem();
        $formkit->label($label);
        $formkit->name($name);
        return $formkit;
    }

    function addPassword(string $label, string $name): ElPassword
    {
        $formkit = $this->appendHTML("<form-kit type='el-password'></form-kit>")[0];
        $formkit->formItem();
        $formkit->label($label);
        $formkit->name($name);
        $formkit->clearable();
        $formkit->showPassword();
        return $formkit;
    }

    function addSelect(string $label, string $name): ElSelect
    {
        $formkit = $this->addElSelect($label, $name);
        $formkit->formItem();
        return $formkit;
    }

    function addRow()
    {
        return $this->addElRow();
    }

    function addInput(string $label, string $name): ElInput
    {
        $formkit = $this->addElInput($label, $name);
        $formkit->formItem();
        return $formkit;
    }

    function addRouterLink(): RouterLink
    {
        return $this->appendHTML("<router-link></router-link>")[0];
    }

    //Vx Component
    function addVxLink(?string $label = null, ?string $to = null): VxLink
    {
        $link = $this->appendHTML("<vx-link></vx-link>")[0];

        if ($label) {
            $link->label($label);
        }

        if ($to) {
            $link->to($to);
        }
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

    function addRepeater(string $label, ?string $name = null): VxRepeater
    {
        $repeater = $this->appendHTML("<form-kit type='repeater'></form-kit>")[0];

        if ($label) {
            $repeater->label($label);
        }

        if ($name) {
            $repeater->name($name);
        }

        return $repeater;
    }

    function addGroup(): Group
    {
        return $this->appendHTML("<form-kit type='group'></form-kit>")[0];
    }

    function addMenu(): ElMenu
    {
        return $this->addElMenu()->router(true)->mode("horizontal");
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
