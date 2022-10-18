<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-06-28 
 */
return new class
{
    function get(VX $vx)
    {
        return $vx->user->toArray([
            "user_id",
            "username",
            "first_name",
            "last_name",
            "email",
            "phone",
            "addr1",
            "addr2",
            "addr3",
            "city",
        ]);
    }
};
