<?php

use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ServerRequestInterface;

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

    function post(VX $vx, ServerRequestInterface $request)
    {
        try {
            $token = $vx->login($request);
        } catch (Exception $e) {
            return new TextResponse($e->getMessage(), 401);
        }
        $path = $vx->base_path;

        //generate cookie string
        $access_token_string = "access_token={$token}; path={$path}; HttpOnly";
        //$refresh_token_string = "refresh_token=" . $token["refresh_token"] . "; path=" . $vx->base_path . "auth/renew-token; SameSite=None; HttpOnly;";

        if ($request->getUri()->getScheme() == "https") {
            $access_token_string .= "; SameSite=None; Secure";
        }

        //set cookie
        $response = new EmptyResponse(200);
        $response = $response->withAddedHeader("Set-Cookie", $access_token_string);
        //$response = $response->withAddedHeader("Set-Cookie", $refresh_token_string);
        return $response;
    }
};
