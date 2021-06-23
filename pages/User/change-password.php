<?php

return ["post" => function (VX $vx) {

    $post = $vx->req->getParsedBody();
    $user = $vx->user;
    $user->password = password_hash($post["password"], PASSWORD_DEFAULT);
    $user->save();

    http_response_code(204);
}];
