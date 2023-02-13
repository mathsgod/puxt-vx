<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-04-26 
 */

use VX\PublicKeyCredentialSourceRepository;
use VX\User;
use Webauthn\PublicKeyCredentialRequestOptions;
use Webauthn\PublicKeyCredentialSource;

return new class
{

    function post(VX $vx)
    {

        
        $source = new PublicKeyCredentialSourceRepository();
        $server = $vx->getWebAuthnServer();

        // UseEntity found using the username.
        $userEntity = $vx->findWebauthnUserByUsername($vx->_post["username"]);

        // Get the list of authenticators associated to the user
        $credentialSources = $source->findAllForUserEntity($userEntity);

        // Convert the Credential Sources into Public Key Credential Descriptors
        $allowedCredentials = array_map(function (PublicKeyCredentialSource $credential) {
            return $credential->getPublicKeyCredentialDescriptor();
        }, $credentialSources);

        // We generate the set of options.
        $publicKeyCredentialRequestOptions = $server->generatePublicKeyCredentialRequestOptions(
            PublicKeyCredentialRequestOptions::USER_VERIFICATION_REQUIREMENT_PREFERRED, // Default value
            $allowedCredentials
        );

        //save the request options
        User::Query(["username" => $vx->_post["username"]])->update([
            "credential_request_options" => json_encode($publicKeyCredentialRequestOptions->jsonSerialize())
        ]);

        return $publicKeyCredentialRequestOptions->jsonSerialize();
    }
};
