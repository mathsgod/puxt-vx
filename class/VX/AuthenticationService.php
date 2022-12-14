<?php

namespace VX;

use Exception;
use Firebase\JWT\JWT;
use TheCodingMachine\GraphQLite\Security\AuthenticationServiceInterface;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function isLogged(): bool
    {
        if (!$access_token = $_COOKIE["access_token"]) {
            return false;
        }

        try {
            $payload = JWT::decode($access_token, $_ENV["JWT_SECRET"], ["HS256"]);
            if ($payload->user_id) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function getUser(): ?object
    {
        if (!$access_token = $_COOKIE["access_token"]) {
            return null;
        }

        try {
            $payload = JWT::decode($access_token, $_ENV["JWT_SECRET"], ["HS256"]);
            if ($payload->user_id) {
                return new User($payload->user_id);
            }
        } catch (Exception $e) {
            return null;
        }

        return null;
    }
}
