<?php

/**
 * @author: Raymond Chong
 * Date: 2022-10-17 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Permissions\Rbac\Rbac;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\ForbiddenException;

return new class
{
    function post(VX $vx, Rbac $rbac)
    {
        $user = $vx->user;

        if (!$rbac->isGranted($user, "user.can_change_password", $user)) {
            throw new ForbiddenException("You are not allowed to change password");
        }

        if (!password_verify($vx->_post["old_password"], $user->password)) {
            throw new BadRequestException("Old password is incorrect");
        }

        if (!$vx->isValidPassword($vx->_post["new_password"])) {
            throw new BadRequestException("Password is not valid");
        }

        $user->password = password_hash($vx->_post["new_password"], PASSWORD_DEFAULT);
        $user->save();

        return new EmptyResponse();
    }
};