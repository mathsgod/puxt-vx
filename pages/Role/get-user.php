<?php

/**
 * @author Raymond Chong
 * @date 2023-01-17 
 */

use VX\Security\UserRepositoryInterface;

return new class
{
    function get(VX $vx, UserRepositoryInterface $user_repo)
    {
        $users = [];
        $role = $vx->_get["role"];

        foreach ($user_repo->all() as $user) {
            $roles = $user->getRoles();

            if (in_array($role, $roles)) {
                $users[] = [
                    "id" => $user->getIdentity(),
                    "name" => $user->getName(),
                    "roles" => $roles,
                ];
            }
        }

        return $users;
    }
};
