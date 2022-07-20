<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-07-07 
 */

use Laminas\Diactoros\Response\EmptyResponse;

return new class
{
    function patch(VX $vx)
    {
        $user = $vx->user;
        if ($vx->_post["language"]) {
            $user->language = $vx->_post["language"];
        }

        $user->save();

        return new EmptyResponse();
    }
};
