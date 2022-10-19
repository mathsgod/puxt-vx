<?php

/**
 * @author: Raymond Chong
 * Date: 2022-10-19 
 */

use Laminas\Diactoros\Response\EmptyResponse;

return new class
{
    function get(VX $vx)
    {

        return new EmptyResponse(404);
    }
};
