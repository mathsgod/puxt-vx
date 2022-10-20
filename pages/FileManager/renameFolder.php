<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-06 
 */
return new class
{
    function post(VX $vx)
    {
        $path = $vx->_post["path"];

        $fs = $vx->getFileSystem();
        $base = dirname($path);
        $target = $base . "/" . $vx->_post["name"];
        $fs->move($vx->_post["path"], $target);

        return [
            "name" => basename($target),
            "path" => $vx->normalizePath($target),
            "location" => $vx->normalizePath($base),
            "last_modified" => $fs->lastModified($target),
        ];
    }
};
