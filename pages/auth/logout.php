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
        return $this->post($vx);
    }


    function post(VX $vx)
    {
        $vx->invalidateJWT($vx->getAccessToken());
        $vx->invalidateJWT($vx->getRefreshToken());

        $resp = new EmptyResponse();

        $access_token_string = "access_token=; path=" . $vx->base_path . "; httponly";
        $refresh_token_string = "refresh_token=; path=" . $vx->base_path . "auth/renew-token; httponly";

        if ($vx->request->getUri()->getScheme() == "https") {
            $access_token_string .= "; Secure";
            $refresh_token_string .= "; Secure";
        }

        $resp = $resp->withAddedHeader("Set-Cookie", $access_token_string);
        $resp = $resp->withAddedHeader("Set-Cookie", $refresh_token_string);

        return $resp;
    }
};
