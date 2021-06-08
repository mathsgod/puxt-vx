<?php

return [
    "get" => function (VX $vx) {
        yield $vx->res->message("hello");
    }
];
