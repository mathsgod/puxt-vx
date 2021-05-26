<?php

return ["get" => function () {
    $_SESSION["VX"]["user_id"] = 2;
    return [
        "status" => 401
    ];
}];
