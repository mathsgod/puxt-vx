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

        if ($token = $vx->_post["token"]) {

            //decode token
            $payload = $vx->decodeJWT($token);
            $user = User::Get($payload->id);
            if (!$user) {
                throw new BadRequestException("User not found");
            }
            $user->password = password_hash($vx->_post["password"], PASSWORD_DEFAULT);
            $user->save();
        }
        return new EmptyResponse();
    }

    function get(VX $vx)
    {

        if (!$vx->user->isAdmin()) {
            //only admin can reset password
            throw new ForbiddenException("You are not allowed to reset password");
        }

        $user = User::Get($vx->_post["user_id"]);
        if (!$user) {
            throw new BadRequestException("User not found");
        }

        $user->password = password_hash($vx->_post["password"], PASSWORD_DEFAULT);
        $user->save();

        return new EmptyResponse();
    }
};
