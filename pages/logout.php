<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-04-14 
 */

use Laminas\Diactoros\Response\EmptyResponse;

return new class
{
    function get(VX $vx)
    {
    }

    function post(VX $vx)
    {
        $resp = new EmptyResponse(200);

        $resp = $resp->withAddedHeader("Set-Cookie", "access_token=; httponly");
        $resp = $resp->withAddedHeader("Set-Cookie", "refresh_token=; path=/renew-token; httponly");

        return $resp;
    }
};
