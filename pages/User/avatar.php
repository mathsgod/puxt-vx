<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-07-06 
 */

use VX\User;

return new class
{
    function get(VX $vx)
    {

        $user = User::FromGlobal();
        if ($user->photo === null) {
            header('Content-Type: image/png');
            readfile(__DIR__ . "/avatar.png");
            die();
        }
        echo $user->photo;
        die();
    }
};
