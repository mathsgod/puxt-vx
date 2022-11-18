<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-11-15 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\User;
use VX\UserList;

return new class
{
    function post(VX $vx)
    {
        $user = User::Get($vx->_post["user_id"]);

        foreach ($user->UserList as $ul) {
            $ul->delete();
        }

        foreach ($vx->_post["usergroup_id"] as $usergroup_id) {
            UserList::Create([
                "user_id" => $user->user_id,
                "usergroup_id" => $usergroup_id
            ])->save();
        }
        return new EmptyResponse();
    }
};
