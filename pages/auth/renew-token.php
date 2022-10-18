<?php

use Firebase\JWT\JWT;
use Laminas\Diactoros\Response\EmptyResponse;
use League\Route\Http\Exception\BadRequestException;
use VX\User;

return new class
{
    function post(VX $vx)
    {
        $refresh_token = $_COOKIE["refresh_token"];
        if (!$refresh_token) {
            throw new BadRequestException("Refresh token not found");
        }

        try {
            $payload = JWT::decode($refresh_token, $vx->config["VX"]["jwt"]["secret"], ["HS256"]);
        } catch (Exception $e) {
            //remove the cookie
            $resp = new EmptyResponse();
            $resp = $resp->withAddedHeader("Set-Cookie", "access_token=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path={$vx->base_path}; SameSite=Strict; HttpOnly");
            $resp = $resp->withAddedHeader("Set-Cookie", "refresh_token=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path={$vx->base_path}auth/renew-token; SameSite=Strict; HttpOnly");
            return $resp;
        }


        if ($payload->type == "refresh_token") {
            $resp = new EmptyResponse();
            $user = User::Get($payload->user_id);
            $access_token_string = "access_token=" . $vx->generateAccessToken($user)  . "; path=" . $vx->base_path . "; SameSite=Strict; HttpOnly";
            if ($vx->request->getUri()->getScheme() == "https") {
                $access_token_string .= "; Secure";
            }

            $resp = $resp->withAddedHeader("Set-Cookie", $access_token_string);
            return $resp;
        }

        throw new BadRequestException("Invalid token");
    }
};
