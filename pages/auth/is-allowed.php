<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-09-14 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\Security\Security;

return new class
{
    function get(VX $vx, Security $security)
    {

        if (!$security->isGranted($vx->user, $vx->_get["path"])) {
            return new EmptyResponse(403);
        }

        return new EmptyResponse(200);
    }
};
