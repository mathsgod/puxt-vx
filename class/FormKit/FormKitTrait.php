<?php

namespace FormKit;

trait FormKitTrait
{
    use Element\ElementTrait;

    function addVxTable(): VxTable
    {
        return $this->appendHTML("<vx-table></vx-table>")[0];
    }

    function addForm(): VxForm
    {
        return $this->appendHTML("<form-kit type='vxForm'></form-kit>")[0];
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
        $formkit = $this->addElSelect($label, $name);
        $formkit->formItem();
        return $formkit;
    }

    function addRow()
    {
        return $this->addElRow();
    }

    function addInput(string $label, string $name)
    {
        $formkit = $this->addElInput($label, $name);
        $formkit->formItem();
        return $formkit;
    }
}
