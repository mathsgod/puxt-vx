<?php

use VX\PublicKeyCredentialSourceRepository;
use VX\User;
use Webauthn\PublicKeyCredentialCreationOptions;
use Webauthn\PublicKeyCredentialRpEntity;
use Webauthn\PublicKeyCredentialUserEntity;

return new class
{
    public function post(VX $vx)
    {
        $token = $vx->_get["token"];
        $token = $vx->decodeJWT($token);
        $user = User::Get($token->id);
        if (!$user) {
            throw new Exception("user not found", 400);
        }

        $server = $vx->getWebAuthnServer();
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
