<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-06 
 */
return new class
{
    function get(VX $vx)
    {
        $fs = $vx->getFileManager();

        $file = $fs->read($vx->_get["path"]);
        $mime = $fs->mimeType($vx->_get["path"]);

        $file = base64_encode($file);
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . basename($vx->_get["path"]) . '"');
        header('Content-Length: ' . strlen($file));
        echo $file;
        exit();
    }
};
