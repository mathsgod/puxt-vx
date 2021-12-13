<?php

return [
    "modules" => [
        "puxt-vx",
    ],

    "database" => [
        "hostname" => "127.0.0.1",
        "username" => "root",
        "password" => "111111",
        "database" => "raymond",
    ],

    "VX" => [
        "jwt" => [
            "secret" => "hostlink secret key"
        ],
        "language" => [
            "en" => "English",
            "zh-hk" => "中文"
        ], "file_mamanger" => [
            [
                "type" => "hostlink-storage",
                "name" => "storage",
                "token" => "hostlink storage token",
                "endpoint" => "http://storage.hostlink.com/",
            ]
        ]
    ]

];
