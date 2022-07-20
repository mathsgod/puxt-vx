<?php


/**
 * Created by: Raymond Chong
 * Date: 2022-07-08 
 */
return new class
{
    function get(VX $vx)
    {
        return ["token" => $vx->generateAccessToken($vx->user, 60)];
    }
};
