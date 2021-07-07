{{table|raw}}

<?php
/**
 * Created by: Raymond Chong
 * Date: 2021-07-05 
 */
return new class
{
    function get(VX $vx)
    {
        $ft = $vx->ui->createFormTable(VX\User::Query()->toArray(), "user_id");
        $ft->add("Username", "username")->input("username");

        $this->table = $ft;
    }
};
