<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-06 
 */
return new class
{
    function post(VX $vx)
    {
        $file = $vx->_post["path"];

        $fs = $vx->getFileSystem();
        $fs->delete($file);
    }
};
