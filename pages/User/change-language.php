<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-06-01 
 */

use Laminas\Diactoros\Response\EmptyResponse;

return new class
{
    function post(VX $vx)
    {

        if ($user = $vx->user) {
            $user->language = $vx->_post["language"];
            $user->save();
        }
        return new EmptyResponse();
    }
};
