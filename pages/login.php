<?php

use Firebase\JWT\JWT;

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

        return [
            "access_token" => $token,
            "refresh_token" => $refresh_token
        ];
    }
};
