<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-04-26 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\User;
use Webauthn\PublicKeyCredentialRequestOptions;

return new class
{
    function post(VX $vx)
    {
        $server = $vx->getWebAuthnServer();
        $server->setSecuredRelyingPartyId(["localhost"]);

        $username = $vx->_get["username"];
        $user = User::Query(["username" => $username, "status" => 0])->first();
        if (!$user) {
            throw new Exception("user not found");
        }
        $userEntity = $vx->findWebauthnUserByUsername($user->username);
        $server->loadAndCheckAssertionResponse(
            json_encode($vx->_post),
            PublicKeyCredentialRequestOptions::createFromArray($user->credential_request_options),
            $userEntity,
            $vx->request
        );

        $access_token_string = "access_token=" . $vx->generateAccessToken($user) . "; path=" . $vx->base_path . "; SameSite=Strict; HttpOnly";
        $refresh_token_string = "refresh_token=" . $vx->generateRefreshToken($user) . "; path=" . $vx->base_path . "auth/renew-token; SameSite=Strict; HttpOnly";
        if ($vx->request->getUri()->getScheme() == "https") {
            $access_token_string .= "; Secure";
            $refresh_token_string .= "; Secure";
        }

        $response = new EmptyResponse(200);
        $response = $response->withAddedHeader("Set-Cookie", $access_token_string);
        $response = $response->withAddedHeader("Set-Cookie", $refresh_token_string);
        return $response;
    }
};
