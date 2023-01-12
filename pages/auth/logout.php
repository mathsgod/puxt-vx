<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-04-14 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ServerRequestInterface;

return new class
{
    function get(VX $vx, ServerRequestInterface $request)
    {
        return $this->post($vx, $request);
    }


    function post(VX $vx, ServerRequestInterface $request)
    {

        if (!$_COOKIE["access_token"]) {
            return new EmptyResponse();
        }


        $vx->invalidateJWT($vx->getAccessToken());

        //$vx->invalidateJWT($vx->getRefreshToken());

        $resp = new EmptyResponse();

        $access_token_string = "access_token=; path=" . $vx->base_path . "; httponly";
        //$refresh_token_string = "refresh_token=; path=" . $vx->base_path . "auth/renew-token; httponly";

        if ($request->getUri()->getScheme() == "https") {
            $access_token_string .= "; Secure";
            //  $refresh_token_string .= "; Secure";
        }

        $resp = $resp->withAddedHeader("Set-Cookie", $access_token_string);
        //$resp = $resp->withAddedHeader("Set-Cookie", $refresh_token_string);

        return $resp;
    }
};
