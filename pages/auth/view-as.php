<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-07-22 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use League\Route\Http\Exception\ForbiddenException;
use VX\User;

return new class
{

    function get(VX $vx)
    {
        $token = $_COOKIE["access_token"];
        $payload = $vx->getPayload($token);

        $user = User::Get($payload->user_id);


        $access_token_string = "access_token=" . $vx->generateAccessToken($user)  . "; path=" . $vx->base_path . "; SameSite=Strict; HttpOnly";

        if ($vx->request->getUri()->getScheme() == "https") {
            $access_token_string .= "; Secure";
        }

        $response = new EmptyResponse(200);
        $response = $response->withAddedHeader("Set-Cookie", $access_token_string);
        return $response;
    }


    function post(VX $vx)
    {
        $view_as = $vx->_post["view_as"];
        $user = $vx->user;

        if (!$user->isAdmin()) {
            //access deny
            throw new ForbiddenException();
        }

        $access_token_string = "access_token=" . $vx->generateAccessToken($user,    $view_as)  . "; path=" . $vx->base_path . "; SameSite=Strict; HttpOnly";

        if ($vx->request->getUri()->getScheme() == "https") {
            $access_token_string .= "; Secure";
        }

        $response = new EmptyResponse(200);
        $response = $response->withAddedHeader("Set-Cookie", $access_token_string);
        return $response;
    }
};
