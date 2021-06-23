<?php

use Gumlet\ImageResize;

return ["post" => function (VX $vx) {

    $files = $vx->req->getUploadedFiles();

    $file = $files["file"];

    $image = ImageResize::createFromString($file->getStream());
    $image->resizeToBestFit(120, 120);

    $user = $vx->user;
    $user->photo = (string)$image;
    $user->save();

    http_response_code(205);
}];
