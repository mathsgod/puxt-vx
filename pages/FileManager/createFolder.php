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

        $path = $vx->normalizePath($vx->_post["path"]);
        return [
            "name" => basename($vx->_post["path"]),
            "path" => $path,
            "location" => $vx->normalizePath(dirname($path)),
            "last_modified" => $fs->lastModified($vx->_post["path"]),
        ];
    }
};
