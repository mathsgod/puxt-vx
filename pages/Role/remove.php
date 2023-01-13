<?php

/**
 * @author Raymond Chong
 * @date 2023-01-13 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\Role;

return new class
{
    function post(VX $vx)
    {
        foreach (Role::Query([
            "name" => $vx->_post["name"],
        ]) as $role) {
            $role->delete();
        }
        return new EmptyResponse();
    }
};
