<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-07-25 
 */
return new class
{
    function post(VX $vx)
    {
        $vx->forgotPassword($vx->_post["username"], $vx->_post["email"]);
    }
};
