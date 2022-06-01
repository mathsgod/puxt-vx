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
        $fs->deleteDirectory($vx->_post["path"]);
    }
};
