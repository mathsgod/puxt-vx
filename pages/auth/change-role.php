<?php

/**
 * @author Raymond Chong
 * @date 2022-12-30 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\User;

return new class
{
    function post(VX $vx)
    {

        $user = User::Get($vx->_post["user_id"]);

        foreach ($user->getRoles() as $role) {
            $user->removeRole($role);
        }

        foreach ($vx->_post["roles"] as $role) {
            $user->addRole($role);
        }

        return new EmptyResponse();
    }
};
