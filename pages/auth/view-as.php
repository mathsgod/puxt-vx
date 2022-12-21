<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-07-22 
 */

use Firebase\JWT\JWT;
use Laminas\Diactoros\Response\EmptyResponse;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\ForbiddenException;
use Ramsey\Uuid\Uuid;
use VX\User;

return new class
{
    function get(VX $vx)
    {
        return new EmptyResponse();
        $token = $_COOKIE["access_token"];
        if (!$token) {
            return new EmptyResponse();
        };
        $response = new EmptyResponse();
        $response = $response->withAddedHeader("Set-Cookie", $token);
        return $response;
    }


    function post(VX $vx)
    {
        $view_as = $vx->_post["view_as"];
        $user = $vx->user;

        if (!$user->is("Administrators")) {
            //access deny
            throw new ForbiddenException();
        }


        $token = JWT::encode([
            "jti" => Uuid::uuid4()->toString(),
            "type" => "access_token",
            "iat" => time(),
            "exp" => time() + 3600 * 8,
            "id" => $user->getIdentity(),
            "view_as" => $view_as
        ], $_ENV["JWT_SECRET"], "HS256");

        $access_token_string = "access_token=" . $token  . "; path=" . $vx->base_path . "; SameSite=Strict; HttpOnly";

        if ($vx->request->getUri()->getScheme() == "https") {
            $access_token_string .= "; Secure";
        }

        $response = new EmptyResponse(200);
        $response = $response->withAddedHeader("Set-Cookie", $access_token_string);
        return $response;
    }
};
