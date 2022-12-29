<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-05-12 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\StyleableInterface;
use VX\User;

return new class
{
    function post(VX $vx)
    {
        if ($vx->user instanceof StyleableInterface) {
            $vx->user->setStyles($vx->_post);
        }

        return new EmptyResponse();
    }

    function get(VX $vx)
    {
        if ($vx->user instanceof StyleableInterface) {
            return $vx->user->getStyles();
        }
        return [];
    }
};
