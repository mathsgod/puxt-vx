<?php

use Firebase\JWT\JWT;
use Laminas\Diactoros\Response\EmptyResponse;

/**
 * Created by: Raymond Chong
 * Date: 2021-08-12 
 */
return new class
{
    function get(VX $vx)
    {
        return ["login page"];
    }

    function post(VX $vx)
    {

        $data = $vx->_post;
        $user = $vx->login($data["username"], $data["password"], $data["code"]);


        $token = JWT::encode([
            "type" => "access_token",
            "iat" => time(),
            "exp" => time() + 3600,
            "user_id" => $user->user_id

        ], $vx->config["VX"]["jwt"]["secret"]);

        $refresh_token = JWT::encode([
            "type" => "refresh_token",
            "iat" => time(),
            "exp" => time() + 3600 * 24, //1 day
            "user_id" => $user->user_id
        ], $vx->config["VX"]["jwt"]["secret"]);

        $response = new EmptyResponse(200);
        $response = $response->withAddedHeader("Set-Cookie", "access_token=" . $token . "; httponly");
        $response = $response->withAddedHeader("Set-Cookie", "refresh_token=" . $refresh_token . "; path=/api/refresh; httponly");
        return $response;
    }
};
