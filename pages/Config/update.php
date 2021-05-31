{{table|raw}}
<?php

use VX\User;

return ["get" => function (VX $vx) {


    
    $ft = $vx->createFormTable(User::Query()->toArray(), "user_id");

    $ft->add("Username", "username")->input("username");


    $this->table = $ft;
    //$t=$vx->createT();


}];
