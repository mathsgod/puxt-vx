<?php

namespace VX;

use Webauthn\PublicKeyCredentialSource;
use Webauthn\PublicKeyCredentialSourceRepository as WebauthnPublicKeyCredentialSourceRepository;
use Webauthn\PublicKeyCredentialUserEntity;

class PublicKeyCredentialSourceRepository implements WebauthnPublicKeyCredentialSourceRepository
{

    public function findOneByCredentialId(string $publicKeyCredentialId): ?PublicKeyCredentialSource
    {
        return null;
    }

    public function  findAllForUserEntity(PublicKeyCredentialUserEntity $publicKeyCredentialUserEntity): array
    {
        $sources = [];
        foreach (User::Query() as $user) {
            if (!$user->credential) continue;

            $source = PublicKeyCredentialSource::createFromArray($user->credential);
            if ($source->getUserHandle() == $publicKeyCredentialUserEntity->getId()) {
                $sources[] = $source;
            }
        }
        return $sources;
    }

    public function saveCredentialSource(PublicKeyCredentialSource $publicKeyCredentialSource): void
    {
    }
}
