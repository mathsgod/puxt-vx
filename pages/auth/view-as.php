<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-07-22 
 */

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Laminas\Diactoros\Response\EmptyResponse;
use League\Route\Http\Exception\ForbiddenException;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use VX\User;

return new class
{
    function get(VX $vx)
    {
        $token = $_COOKIE["access_token"];
        if (!$token) {
            return new EmptyResponse();
        }

        $payload = JWT::decode($token, new Key($_ENV["JWT_SECRET"], "HS256"));

        $user = User::Get($payload->id);
        $token = JWT::encode([
            "jti" => Uuid::uuid4()->toString(),
            "type" => "access_token",
            "iat" => time(),
            "exp" => time() + 3600 * 8,
            "id" => $user->getIdentity(),
        ], $_ENV["JWT_SECRET"], "HS256");

        $access_token_string = "access_token=" . $token  . "; path=" . $vx->base_path . "; SameSite=Strict; HttpOnly";

        $response = new EmptyResponse();
        $response = $response->withAddedHeader("Set-Cookie", $access_token_string);
        return $response;
    }


    function post(VX $vx, ServerRequestInterface $request)
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

        if ($request->getUri()->getScheme() == "https") {
            $access_token_string .= "; Secure";
        }

        $response = new EmptyResponse(200);
        return $response->withAddedHeader("Set-Cookie", $access_token_string);
    }
};
