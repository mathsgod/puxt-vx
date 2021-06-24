<?php

use VX\PublicKeyCredentialSourceRepository;
use Webauthn\PublicKeyCredentialCreationOptions;
use Webauthn\PublicKeyCredentialRpEntity;

return new class
{
    function post(VX $vx)
    {
        $user = $vx->user;



        $rp = new PublicKeyCredentialRpEntity($_SERVER["HTTP_HOST"]);
        $repo = new PublicKeyCredentialSourceRepository();
        $server = new Webauthn\Server($rp, $repo);

        $publicKeyCredentialCreationOptions = PublicKeyCredentialCreationOptions::createFromArray($user->credential_creation_options);


        $publicKeyCredentialSource = $server->loadAndCheckAttestationResponse(
            json_encode($vx->_post),
            $publicKeyCredentialCreationOptions,
            $vx->req
        );

        $repo->saveCredentialSource($publicKeyCredentialSource);
        $user->credential = $publicKeyCredentialSource->jsonSerialize();
        $user->save();
        http_response_code(204);
    }
};
