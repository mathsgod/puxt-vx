<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-06 
 */
return new class
{
    function post(VX $vx)
    {
        $file = $vx->req->getUploadedFiles()["file"];

        
        $fs = $vx->getFileManager();
        $fs->write($vx->_post["path"] . "/" . $file->getClientFilename(), $file->getStream()->getContents());
    }
};
