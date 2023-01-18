<?php

/**
 * @author Raymond Chong
 * @date 2023-01-17 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\User\Favoriteable;

return new class
{
    function get(VX $vx)
    {
    }
    function post(VX $vx)
    {
        $user = $vx->user;
        if ($user instanceof Favoriteable) {
            $user->removeFavorite($vx->_post["id"]);
        }

        return new EmptyResponse();
    }
};
