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
        $base = dirname($vx->_post["path"]);
        $target = $base . DIRECTORY_SEPARATOR . $vx->_post["name"];


        $ext = pathinfo($target, PATHINFO_EXTENSION);
        if (in_array($ext, FileManager::$DisallowExt)) {
            throw new Exception("extension not allow");
        }

        $fs = $vx->getFileSystem();
        $fs->move($vx->_post["path"], $target);
    }
};
