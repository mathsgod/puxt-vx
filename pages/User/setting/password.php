<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-05-12 
 */

use League\Route\Http\Exception\BadRequestException;
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

        if (!password_verify($vx->_post["old_password"], $user->password)) {
            throw new BadRequestException("Old password is incorrect");
        }

        if (!$vx->isValidPassword($vx->_post["new_password"])) {
            throw new BadRequestException("Password is not valid");
        }

        if (!$user->canChangePasswordBy($vx->user)) {
            throw new ForbiddenException("You are not allowed to change this user's password");
        }

        $user->password = password_hash($vx->_post["password"], PASSWORD_DEFAULT);
        $user->save();
    }

    function get(VX $vx)
    {
        return ["rules" => $vx->getPasswordPolicy()];
    }
};
