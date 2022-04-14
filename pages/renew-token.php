<?php

use Firebase\JWT\JWT;
use Laminas\Diactoros\Response\EmptyResponse;

return new class
{
    function post(VX $vx)
    {
        $refresh_token = $_COOKIE["refresh_token"];
        if (!$refresh_token) {
            throw new Exception("no refresh token");
        }

        $payload = (array)JWT::decode($refresh_token, $vx->config["VX"]["jwt"]["secret"], ["HS256"]);
        if ($payload["type"] == "refresh_token") {
            $token = JWT::encode([
                "type" => "access_token",
                "iat" => time(),
                "exp" => time() + 3600,
                "user_id" => $payload["user_id"]
            ], $vx->config["VX"]["jwt"]["secret"]);

            $resp = new EmptyResponse(200);
            $resp = $resp->withAddedHeader("Set-Cookie", "access_token=" . $token . "; httponly");
            return $resp;
        }
        throw new Exception("error when renew access token");
    }
};
