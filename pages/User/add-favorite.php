<?php

/**
 * @author Raymond Chong
 * @date 2023-01-16 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\User\Favoriteable;

return new class
{
    function post(VX $vx)
    {
        $user = $vx->user;

        if ($user instanceof Favoriteable) {
            $user->addFavorite($vx->_post["label"], $vx->_post["path"], $vx->_post["icon"]);
            return new EmptyResponse();
        }

        return new EmptyResponse(400);
    }
};
