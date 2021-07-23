<?php

use Gumlet\ImageResize;

/**
 * Created by: Raymond Chong
 * Date: 2021-07-23 
 */
return new class
{
    function get(VX $vx)
    {
    }

    function  post(VX $vx)
    {

        $files = $vx->req->getUploadedFiles();

        $file = $files["file"];

        $image = ImageResize::createFromString($file->getStream());
        $image->resizeToBestFit(120, 120);

        $user = $vx->user;
        $user->photo = (string)$image;
        $user->save();

        http_response_code(204);
    }
};
