<?php

namespace VX;

use Exception;

class User extends Model
{
    public static function Login(string $username, string $password, $code = null) 
    {
        $user = self::Query([
            "username" => $username,
            "status" => 0
        ])->first();

        if (!$user) {
            throw new Exception("user not found");
        }

        //check password
        if (!password_verify($password, $user->password)) {
            throw new Exception("password error");
        }

        if ($user->expiry_date && strtotime($user->expiry_date) < time()) {
            throw new Exception("user expired");
        }

        if ($user->UserList->count() == 0) {
            throw new Exception("no any user group");
        }

        return $user;
    }
}
