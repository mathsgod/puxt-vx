<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-05-12 
 */
return new class
{
    function get(VX $vx)
    {
        $user = $vx->user;

        return [
            "user_id" => $user->user_id,
            "phone" => $user->phone,
            "addr1" => $user->addr1,
            "addr2" => $user->addr2,
            "addr3" => $user->addr3,
        ];
    }
};
