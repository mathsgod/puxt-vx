<?php

/**
 * @author Raymond Chong
 * @date 2023-01-13 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\Security\RoleRepositoryInterface;

return new class
{
    function post(VX $vx, RoleRepositoryInterface $roles)
    {

        if ($role = $roles->findById($vx->_post["name"])) {
            $roles->delete($role);
        }

        return new EmptyResponse();
    }
};
