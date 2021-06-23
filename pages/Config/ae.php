{{f|raw}}
<?php

use VX\UserGroup;

return [
    "get" => function (VX $vx) {

        $f = $vx->ui->createForm();
        $f->add("Name")->input("name")->required();
        $f->add("Value")->input("value");

        $this->f = $f;
    }
];
