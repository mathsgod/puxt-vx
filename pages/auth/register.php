<?php

use Laminas\Diactoros\Response\EmptyResponse;
use Ramsey\Uuid\Uuid;
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
            $vx->request
        );

        //$repo->saveCredentialSource($publicKeyCredentialSource);
        $user->credential[] = [
            "uuid" => Uuid::uuid4()->toString(),
            "ip" => $_SERVER["REMOTE_ADDR"],
            "user-agent" => $_SERVER["HTTP_USER_AGENT"],
            "timestamp" => time(),
            "credential" => $publicKeyCredentialSource->jsonSerialize()
        ];

        $user->save();
        return new EmptyResponse();
    }
};
