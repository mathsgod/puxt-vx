<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-06 
 */

use VX\FileManager;

return new class
{
    function post(VX $vx)
    {
        $path = $vx->_post["path"];
        $base = dirname($path);
        $target = $base . "/" . $vx->_post["name"];

        $ext = pathinfo($target, PATHINFO_EXTENSION);
        if (in_array($ext, FileManager::$DisallowExt)) {
            throw new Exception("extension not allow");
        }

        $fs = $vx->getFileSystem();
        $fs->move($vx->_post["path"], $target);

        return [
            "name" => basename($target),
            "path" => $vx->normalizePath($target),
            "location" => $vx->normalizePath($base),
            "last_modified" => $fs->lastModified($target),
            "size" => $fs->fileSize($target),
            "mime_type" => $fs->mimeType($target)
        ];
    }
};
