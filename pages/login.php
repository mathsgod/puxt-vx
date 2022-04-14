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


        $access_token_string = "access_token=" . $token . "; SameSite=Strict; HttpOnly";
        $refresh_token_string = "refresh_token=" . $refresh_token . "; path=/api/renew-token; SameSite=Strict; HttpOnly";
        if ($vx->request->getUri()->getScheme() == "https") {
            $access_token_string .= "; Secure";
            $refresh_token_string .= "; Secure";
        }

        $response = new EmptyResponse(200);
        $response = $response->withAddedHeader("Set-Cookie", $access_token_string);
        $response = $response->withAddedHeader("Set-Cookie", $refresh_token_string);
        return $response;
    }
};
