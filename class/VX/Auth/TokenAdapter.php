<?php

namespace VX\Auth;

use Exception;
use Firebase\JWT\JWT;
use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\Result;
use VX\User;

class TokenAdapter implements AdapterInterface
{
    protected $token;
    protected $secret;

    public function __construct(string $token, string $secret)
    {
        $this->token = $token;
        $this->secret = $secret;
    }

    public function authenticate()
    {
        try {
            $payload = JWT::decode($this->token, $this->secret, ['HS256']);
            $user = User::Get($payload->user_id);
            if (!$user) {
                return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null, ["User not found"]);
            }

            if ($user->expiry_date && strtotime($user->expiry_date) < time()) {
                return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ["User account expired"]);
            }

            if ($user->status != 0) {
                return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ["User account disabled"]);
            }

            return new Result(Result::SUCCESS, $user->user_id);
        } catch (Exception $e) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, [$e->getMessage()]);
        }
    }
}
