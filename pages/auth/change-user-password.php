<?php

/**
 * @author: Raymond Chong
 * Date: 2022-10-17 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\ForbiddenException;
use VX\User;

return new class
{
    function post(VX $vx)
    {

        //only admin can change password
        if (!$vx->user->isAdmin()) {
            throw new ForbiddenException("Only admin can change this user's password");
        }

        $user = User::Get($vx->_post["user_id"]);

        if (!$user->canChangePasswordBy($vx->user)) {
            throw new ForbiddenException("You are not allowed to change password");
        }

        if (!$vx->isValidPassword($vx->_post["password"])) {
            throw new BadRequestException("Password is not valid");
        }

        $user->password = password_hash($vx->_post["password"], PASSWORD_DEFAULT);
        $user->save();

        return new EmptyResponse();
    }
};
