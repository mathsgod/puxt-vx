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
            "photo" => $user->photo(),
            "username" => $user->username,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email
        ];
    }
};
