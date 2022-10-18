<?php

/**
 * @author: Raymond Chong
 * Date: 2022-10-17 
 */
return new class
{
    function get(VX $vx)
    {
        return $vx->getPasswordPolicy();
    }
};
