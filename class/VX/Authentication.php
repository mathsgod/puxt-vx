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

        $body = $request->getParsedBody();


        $cookies = $request->getCookieParams();
        $access_token = $cookies["access_token"];

        $params = $request->getQueryParams();
        if ($params["_token"]) {
            $access_token = $params["_token"];
        }


        if (!$access_token) {
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
