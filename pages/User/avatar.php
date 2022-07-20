<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-06-09 
 */
return new class
{
    function get(VX $vx)
    {

        $user = $vx->user;
        if ($user->photo === null) {
            header('Content-Type: image/png');
            readfile(dirname(__DIR__, 2) . "/www/images/user.png");
            die();
        } else {
            header('Content-Type: image/png');
            echo $user->photo;
            die();
        }
    }
};
