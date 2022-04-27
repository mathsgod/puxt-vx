<?php

use Firebase\JWT\JWT;
use Laminas\Diactoros\Response\EmptyResponse;
use VX\User;

return new class
{
    function post(VX $vx)
    {
        $refresh_token = $_COOKIE["refresh_token"];
        if (!$refresh_token) {
            throw new Exception("no refresh token");
        }

        $payload = JWT::decode($refresh_token, $vx->config["VX"]["jwt"]["secret"], ["HS256"]);

        if ($payload->type == "refresh_token") {
            $resp = new EmptyResponse(200);
            $user = User::Get($payload->user_id);
            $access_token_string = "access_token=" . $vx->generateAccessToken($user)  . "; path=" . $vx->base_path . "; SameSite=Strict; HttpOnly";
            if ($vx->request->getUri()->getScheme() == "https") {
                $access_token_string .= "; Secure";
            }

            $resp = $resp->withAddedHeader("Set-Cookie", $access_token_string);
            return $resp;
        }
        throw new Exception("error when renew access token");
    }
};
