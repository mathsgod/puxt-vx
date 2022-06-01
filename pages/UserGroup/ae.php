{{form|raw}}
<?php
return new class
{
    function get(VX $vx)
    {
        $form = $vx->ui->createForm();
        $form->add("Name")->input("name")->required();
        $form->add("Remark", ["col" => 12])->textarea("remark");
        $this->form = $form;
    }
};
