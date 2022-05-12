<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-05-12 
 */

use League\Route\Http\Exception\ForbiddenException;
use VX\User;

return new class
{
    function post(VX $vx)
    {
        $user = User::FromGlobal();
        if (!$user->user_id) {
            $user = $vx->user;
        }

        if ($user->canChangePasswordBy($vx->user)) {
            $user->password = password_hash($vx->_post["password"], PASSWORD_DEFAULT);
            $user->save();
        } else {
            throw new ForbiddenException("You are not allowed to change this user's password");
        }
    }
};
