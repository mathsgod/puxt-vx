<?php

use Firebase\JWT\JWT;

return [
    "get" => function (VX $context) {
    },
    "post" => function (VX $context) {
        $data = $context->req->getParsedBody();

        $user = $context->login($data["username"], $data["password"]);

        $token = JWT::encode([
            "type" => "access_token",
            "iat" => time(),
            "exp" => time() + 3600,
            "user_id" => $user->user_id
        ], $context->config["VX"]["jwt"]["secret"]);

        $refresh_token = JWT::encode([
            "type" => "refresh_token",
            "iat" => time(),
            "exp" => time() + 3600 * 24, //1 day
            "user_id" => $user->user_id
        ], $context->config["VX"]["jwt"]["secret"]);

        return ["data" => [
            "access_token" => $token,
            "refresh_token" => $refresh_token
        ]];
    }
];
