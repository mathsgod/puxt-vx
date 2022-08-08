<?php

use Firebase\JWT\JWT;
use Laminas\Diactoros\Response\EmptyResponse;
use VX\JWTBlacklist;

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

        $access_token_string = "access_token=" . $vx->generateAccessToken($user)  . "; path=" . $vx->base_path . "; SameSite=Strict; HttpOnly";
        $refresh_token_string = "refresh_token=" . $vx->generateRefreshToken($user) . "; path=" . $vx->base_path . "auth/renew-token; SameSite=Strict; HttpOnly";

        //logout
        $refresh_token_string_logout = "refresh_token=" . $vx->generateRefreshToken($user) . "; path=" . $vx->base_path . "auth/logout; SameSite=Strict; HttpOnly";


        if ($vx->request->getUri()->getScheme() == "https") {
            $access_token_string .= "; Secure";
            $refresh_token_string .= "; Secure";
            $refresh_token_string_logout .= "; Secure";
        }

        $response = new EmptyResponse(200);
        $response = $response->withAddedHeader("Set-Cookie", $access_token_string);
        $response = $response->withAddedHeader("Set-Cookie", $refresh_token_string);
        $response = $response->withAddedHeader("Set-Cookie", $refresh_token_string_logout);
        return $response;
    }
};
