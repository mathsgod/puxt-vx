<?php

/**
 * @author Raymond Chong
 * @date 2022-12-30 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\User;
use VX\UserRole;

return new class
{
    function post(VX $vx)
    {
        $user = User::Create([
            "username" => $vx->_post["username"],
            "first_name" => $vx->_post["first_name"],
            "last_name" => $vx->_post["last_name"],
            "email" => $vx->_post["email"],
            "phone" => $vx->_post["phone"],
            "password" => password_hash($vx->_post["password"], PASSWORD_DEFAULT),
            "address1" => $vx->_post["address1"],
            "address2" => $vx->_post["address2"],
            "address3" => $vx->_post["address3"],
            "join_date" => $vx->_post["join_date"],
            "status" => $vx->_post["status"],
            "expiry_date" => $vx->_post["expiry_date"],
            "language" => $vx->_post["language"],
            "default_page" => $vx->_post["default_page"],
        ]);

        $user->save();
        foreach ($vx->_post["role"] as $role) {

            //only admin can add admin
            if ($role == "Administrators" && !$vx->user->is("Administrators")) continue;

            UserRole::Create([
                "user_id" => $user->user_id,
                "role" => $role
            ])->save();
        }

        return new EmptyResponse(200);
    }
};
