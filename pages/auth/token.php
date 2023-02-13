<?php

/**
 * @author Raymond Chong
 * @date 2023-02-10 
 */
return new class
{
    function get(VX $vx)
    {
        $user = $vx->user;
        if (!$user) {
            throw new Exception("user not found");
        }

        return ["token" => $vx->getAccessToken()];
    }
};
