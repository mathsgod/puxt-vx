<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-05-12 
 */

use Symfony\Contracts\Translation\TranslatorInterface;

return new class
{
    function get(VX $vx, TranslatorInterface $translator)
    {
        $schema = $vx->createSchema();
        $schema->addInput("phone")->label("Phone");
        $schema->addInput("addr1")->label("Address1");
        $schema->addInput("addr2")->label("Address2");
        $schema->addInput("addr3")->label("Address3");

        return [
            "schema" => $schema,
            "data" => [
                "user_id" => $vx->user->getIdentity(),
                "phone" => $vx->user->phone,
                "addr1" => $vx->user->addr1,
                "addr2" => $vx->user->addr2,
                "addr3" => $vx->user->addr3,
            ]
        ];
    }
};
