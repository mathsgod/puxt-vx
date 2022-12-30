<?php

/**
 * @author Raymond Chong
 * @date 2022-12-30 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\Permission;

return new class
{
    function get(VX $vx)
    {
    }

    function post(VX $vx)
    {

        Permission::Query(["role" => $vx->_post["role"]])->delete();

        foreach ($vx->_post["values"] as $value) {
            if (!$value) continue;
            Permission::Create([
                "role" => $vx->_post["role"],
                "value" => $value
            ])->save();
        }
        return new EmptyResponse();
    }
};
