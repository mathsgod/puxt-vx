<?php

namespace VX;


use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
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

        /*  $tok = JWT::encode(["test" => 1], $_ENV["JWT_SECRET"], "HS256");;
        echo $tok;
        print_r(JWT::decode($tok,  new Key($_ENV["JWT_SECRET"], "HS256")));
        die(); */



        try {
            $payload = JWT::decode($access_token,  new Key($_ENV["JWT_SECRET"], "HS256"));

            if ($payload->view_as) {
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
