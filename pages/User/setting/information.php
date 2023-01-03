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
        return [
            [
                '$formkit' => "elFormInput",
                "label" => $translator->trans("Phone"),
                "name" => "phone",
            ], [
                '$formkit' => "elFormInput",
                "label" => $translator->trans("Address1"),
                "name" => "addr1",
            ],
            [
                '$formkit' => "elFormInput",
                "label" => $translator->trans("Address2"),
                "name" => "addr2",
            ],
            [
                '$formkit' => "elFormInput",
                "label" => $translator->trans("Address3"),
                "name" => "addr3",
            ],
        ];
    }
};
