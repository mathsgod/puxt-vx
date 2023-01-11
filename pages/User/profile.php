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
            "username" => $user->username,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "phone" => $user->phone,
            "addr1" => $user->addr1,
            "addr2" => $user->addr2,
            "addr3" => $user->addr3,
            "join_date" => $user->join_date,
            "language" => $user->language,
            "default_page" => $user->default_page,
            "getRoles" => join(",", $user->getRoles())
        ];
    }
};
