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
            $style = $vx->user->getStyles();
            foreach ($vx->_post as $k => $v) {
                $style[$k] = $v;
            }
            $vx->user->setStyles($style);
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
