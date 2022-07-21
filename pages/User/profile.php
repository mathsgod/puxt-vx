<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-08-26 
 */
return new class
{
    function get(VX $vx)
    {
        $user = $vx->user;
        return [
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
        ];
    }
};
