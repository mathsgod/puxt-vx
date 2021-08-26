{{form|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-08-26 
 */
return new class
{
    function get(VX $vx)
    {
        $form = $vx->ui->createForm([]);
        $form->add("Name")->input("name")->required();
        $this->form = $form;
    }
};
