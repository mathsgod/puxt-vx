<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-06 
 */
return new class
{
    function post(VX $vx)
    {
        $fs = $vx->getFileSystem();

        $fs->createDirectory($vx->_post["path"]);

        $path = $vx->_post["path"];
        return [
            "label" => basename($path),
            "path" => $path
        ];
    }
};
