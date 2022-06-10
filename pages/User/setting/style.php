<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-05-12 
 */

use Laminas\Diactoros\Response\EmptyResponse;

return new class
{

    function post(VX $vx)
    {
        
        $user = $vx->user;
        foreach ($vx->_post as $k => $v) {
            $user->style[$k] = $v;
        }
        $user->save();

        return new EmptyResponse();
    }

    function get(VX $vx)
    {
        $user = $vx->user;
        $style = $user->style ?? [];
        return $style;
    }
};