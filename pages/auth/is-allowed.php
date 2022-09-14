<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-09-14 
 */

use Laminas\Diactoros\Response\EmptyResponse;

return new class
{
    function get(VX $vx)
    {

        return new EmptyResponse(200);
    }
};
