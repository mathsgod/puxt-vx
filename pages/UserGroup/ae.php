{{form|raw}}
<?php
return new class
{
    function get(VX $vx)
    {
        $form = $vx->ui->createForm();
        $form->add("Name")->input("name");//->required();
        $form->add("Remark")->textarea("remark");
        $this->form = $form;
    }
};
