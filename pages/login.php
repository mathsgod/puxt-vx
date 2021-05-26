<?php
return ["post" => function (VX $context) {
    $data = $context->req->getParsedBody();


    $context->login($data["username"], $data["password"]);
    return ["data" => true];
}];
