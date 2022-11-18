<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-05-12 
 */
return new class
{
    function get(VX $vx)
    {
        return [
            [
                '$formkit' => "elFormInput",
                "label" => "Phone",
                "name" => "phone",
            ], [
                '$formkit' => "elFormInput",
                "label" => "Address1",
                "name" => "addr1",
            ],
            [
                '$formkit' => "elFormInput",
                "label" => "Address2",
                "name" => "addr2",
            ],
            [
                '$formkit' => "elFormInput",
                "label" => "Address3",
                "name" => "addr3",
            ],
        ];
    }
};
