<?php

/**
 * @author Raymond Chong
 * @date 2023-01-19 
 */

use VX\StyleableInterface;

return new class
{
    function get(VX $vx)
    {
        if ($vx->user instanceof StyleableInterface) {
            $style = $vx->user->getStyles();
        } else {
            $style = [];
        }
        return $style;
    }
};
