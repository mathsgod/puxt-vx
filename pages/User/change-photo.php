<?php

use Gumlet\ImageResize;
use Laminas\Diactoros\Response\EmptyResponse;

/**
 * Created by: Raymond Chong
 * Date: 2021-07-23 
 */
return new class
{

    function  post(VX $vx)
    {

        $files = $vx->request->getUploadedFiles();

        $file = $files["file"];

        $image = ImageResize::createFromString($file->getStream());
        $image->resizeToBestFit(120, 120);

        $user = $vx->user;
        $user->photo = (string)$image;
        $user->save();

        return new EmptyResponse(204);
    }
};
