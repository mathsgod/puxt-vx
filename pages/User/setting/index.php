<?php

/**
 * @author Raymond Chong
 * @date 2023-01-19 
 */

use FormKit\Schema;

return new class
{
    function get(VX $vx)
    {

        $schema = new Schema;
        $schema->addInput("username")->label("Username")->validation("required");
        $schema->addInput("email")->label("Email")->validation("required|email");
        $schema->addInput("first_name")->label("First name")->validation("required");
        $schema->addInput("last_name")->label("Last name");

        $user = $vx->user;
        return [
            "schema" => $schema,
            "data" => [
                "user_id" => $user->getIdentity(),
                "username" => $user->username,
                "email" => $user->email,
                "first_name" => $user->first_name,
                "last_name" => $user->last_name,
            ]
        ];
    }
};
