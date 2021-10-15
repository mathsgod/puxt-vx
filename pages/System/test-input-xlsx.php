{{form|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-10-12 
 */
return new class
{
    function post(VX $vx)
    {
        outp($vx->_post);
        die();
    }

    function get(VX $vx)
    {
        $form = $vx->ui->createForm([]);

        $form->add("xlsx")->inputXlsx("xlsx");


        $form->add("xlsx2")->inputXlsx("xlsx", [
            "EMAIL" => [
                "prop" => "email"
            ]
        ]);

        $form->setAction("");
        $this->form = $form;
    }
};
