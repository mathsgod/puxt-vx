<?php

use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\TextResponse;

/**
 * Created by: Raymond Chong
 * Date: 2021-08-12 
 */
return new class
{
    function get()
    {
        return new HtmlResponse(file_get_contents(__DIR__ . "/login.html"));
    }

    function post(VX $vx)
    {
        try {
            $token = $vx->login();
        } catch (Exception $e) {
            return new TextResponse($e->getMessage(), 401);
        }

        //generate cookie string
        $access_token_string = "access_token=" . $token  . "; path=" . $vx->base_path . "; SameSite=None; HttpOnly;Secure ";
        //$refresh_token_string = "refresh_token=" . $token["refresh_token"] . "; path=" . $vx->base_path . "auth/renew-token; SameSite=None; HttpOnly;Secure";

        /*         if ($vx->request->getUri()->getScheme() == "https") {
            $access_token_string .= "; SameSite=None; Secure";
            $refresh_token_string .= "; SameSite=None; Secure";
        }
 */
        $response = new EmptyResponse(200);
        $response = $response->withAddedHeader("Set-Cookie", $access_token_string);
        //$response = $response->withAddedHeader("Set-Cookie", $refresh_token_string);
        return $response;
    }
};
