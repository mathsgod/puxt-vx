<?php

namespace VX;

use Exception;
use Firebase\JWT\JWT;
use VX\Authentication\AuthenticationInterface;
use VX\Security\UserInterface;
use Psr\Http\Message\ServerRequestInterface;

class Authentication implements AuthenticationInterface
{
    public function authenticate(ServerRequestInterface $request): ?UserInterface
    {

        $cookies = $request->getCookieParams();
        if (!$access_token = $cookies["access_token"]) {

            return User::Get(2);
        }

        try {
            $payload = JWT::decode($access_token, $_ENV["JWT_SECRET"], ["HS256"]);
            if ($payload->user_id) {
                return User::Get($payload->user_id);
            }
        } catch (Exception $e) {
            //default user
            return User::Get(2);
        }


        return User::Get(2);
    }
}
