{{t|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-11-15 
 */

use VX\User;

return new class
{
    function get(VX $vx)
    {
        $t = $vx->ui->createTable("getData");
        $t->add("Username", "username");
        $this->t = $t;
    }

    function getData(VX $vx)
    {
        $resp = $vx->ui->createTableResponse();
        $resp->setData(User::Query());

        throw new Exception("test", 400);
        return $resp;
    }
};
