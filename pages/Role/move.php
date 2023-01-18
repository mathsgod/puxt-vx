<?php

/**
 * @author Raymond Chong
 * @date 2023-01-16 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\Role;

return new class
{
    function get(VX $vx)
    {
    }

    function post(VX $vx)
    {
        $role = Role::Get(["name" => $vx->_post["name"]]);
        if ($role) {
            $role->parent = $vx->_post["parent"];
            $role->save();
        }

        return new EmptyResponse();
    }
};
