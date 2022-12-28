<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-05-12 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\User;

return new class
{

    function patch(VX $vx)
    {
        if ($vx->user instanceof User) {
            $user = $vx->user;
            foreach ($vx->_post as $k => $v) {
                $user->style[$k] = $v;
            }

            $user->save();
        }

        return new EmptyResponse();
    }

    function post(VX $vx)
    {
        if ($vx->user instanceof User) {
            $user = $vx->user;
            foreach ($vx->_post as $k => $v) {
                $user->style[$k] = $v;
            }
            $user->save();
        }

        return new EmptyResponse();
    }

    function get(VX $vx)
    {
        $user = $vx->user;
        if ($user->style) {
            return $user->style;
        } else {
            return [];
        }
    }
};
