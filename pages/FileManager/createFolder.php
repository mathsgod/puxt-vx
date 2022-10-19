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

        $parent = dirname($path);
        //replace \ with /
        $parent = str_replace(DIRECTORY_SEPARATOR, "/", $parent);

        return [
            "name" => basename($path),
            "path" => $path,
            "location" => $parent
        ];
    }
};
