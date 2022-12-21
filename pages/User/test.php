<?php

/**
 * @author Raymond Chong
 * @date 2022-12-20 
 */

use VX\Security\Security;

return new class
{
    function get(Security $security, VX $vx)
    {

        
        echo $vx->isGranted("can_change_password", $vx->user);
        die();
    }
};
