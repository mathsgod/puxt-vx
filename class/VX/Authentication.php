<?php

namespace VX;


use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use VX\Security\AuthenticationInterface;
use VX\Security\UserInterface;
use Psr\Http\Message\ServerRequestInterface;
use VX;

class Authentication implements AuthenticationInterface
{
    public function authenticate(ServerRequestInterface $request): ?UserInterface
    {
        $cookies = $request->getCookieParams();

        if (!$access_token = $cookies["access_token"]) {
            return User::Get(2);
        }


        try {
            $payload = JWT::decode($access_token,  new Key($_ENV["JWT_SECRET"], "HS256"));


            if ($payload->view_as) {
                $vx = $request->getAttribute(VX::class);
                $vx->view_as = $payload->view_as;
                return User::Get($payload->view_as);
            }

            if ($payload->id) {
                return User::Get($payload->id);
            }
        } catch (Exception $e) {

            return User::Get(2);
        }


        return User::Get(2);
    }
}
