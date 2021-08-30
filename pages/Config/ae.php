{{f|raw}}
<?php

use VX\UserGroup;

/**
 * Created by: Raymond Chong
 * Date: 2021-08-30 
 */
return new class
{
    function get(VX $vx)
    {
        $f = $vx->ui->createForm();
        $f->add("Name")->input("name")->required();
        $f->add("Value")->input("value");

        $this->f = $f;
    }
};
