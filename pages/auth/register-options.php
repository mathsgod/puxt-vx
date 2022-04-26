<?php

use VX\PublicKeyCredentialSourceRepository;
use Webauthn\PublicKeyCredentialCreationOptions;
use Webauthn\PublicKeyCredentialRpEntity;
use Webauthn\PublicKeyCredentialUserEntity;

return new class
{
    public function post(VX $vx)
    {

        $server = $vx->getWebAuthnServer();
        $user = $vx->user;
        $userEntity = new PublicKeyCredentialUserEntity($user->username, $user->user_id, $user->first_name . " " . $user->last_name);


        // Convert the Credential Sources into Public Key Credential Descriptors
        $option = $server->generatePublicKeyCredentialCreationOptions(
            $userEntity,
            PublicKeyCredentialCreationOptions::ATTESTATION_CONVEYANCE_PREFERENCE_NONE
        );

        $user->credential_creation_options = $option;
        $user->save();

        return $option->jsonSerialize();
    }
};
