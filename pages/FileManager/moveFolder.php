<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-06 
 */
return new class
{
    function post(VX $vx)
    {

        $target = $vx->_post["target"] . DIRECTORY_SEPARATOR . basename($vx->_post["path"]);

        $fs = $vx->getFileSystem();
        $fs->move($vx->_post["path"], $target);

        return [
            "path" => $target
        ];
    }
};
