<?php

use VX\PublicKeyCredentialSourceRepository;
use Webauthn\PublicKeyCredentialCreationOptions;
use Webauthn\PublicKeyCredentialOptions;
use Webauthn\PublicKeyCredentialRpEntity;
use Webauthn\PublicKeyCredentialSource;
use Webauthn\PublicKeyCredentialUserEntity;

return new class
{
    public function post(VX $vx)
    {
        $user = $vx->user;
        $userEntity = new PublicKeyCredentialUserEntity($user->username, $user->user_id, $user->first_name . " " . $user->last_name);

        $rp = new PublicKeyCredentialRpEntity($_SERVER["HTTP_HOST"]);
        $source = new PublicKeyCredentialSourceRepository();
        $server = new Webauthn\Server($rp, $source);

        // Convert the Credential Sources into Public Key Credential Descriptors
        $option = $server->generatePublicKeyCredentialCreationOptions(
            $userEntity,
            PublicKeyCredentialCreationOptions::ATTESTATION_CONVEYANCE_PREFERENCE_NONE
        );

        $user->credential_creation_options=$option;
        $user->save();

        return $option->jsonSerialize();
    }
};
