<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-09-30 
 */

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

return new class
{
    function get(VX $vx)
    {


        outp($vx);
        outp($resp);
    }
};
