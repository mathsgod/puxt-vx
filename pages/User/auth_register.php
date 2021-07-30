<?php

use VX\PublicKeyCredentialSourceRepository;
use Webauthn\PublicKeyCredentialCreationOptions;
use Webauthn\PublicKeyCredentialRpEntity;

return new class
{
    function post(VX $vx)
    {
        $user = $vx->user;

        $server = $vx->getWebAuthnServer();

        $publicKeyCredentialCreationOptions = PublicKeyCredentialCreationOptions::createFromArray($user->credential_creation_options);

        $server->setSecuredRelyingPartyId(["localhost"]);

        $publicKeyCredentialSource = $server->loadAndCheckAttestationResponse(
            json_encode($vx->_post),
            $publicKeyCredentialCreationOptions,
            $vx->req
        );

        //$repo->saveCredentialSource($publicKeyCredentialSource);
        $user->credential[] = $publicKeyCredentialSource->jsonSerialize();
        $user->save();
        http_response_code(204);
    }
};
