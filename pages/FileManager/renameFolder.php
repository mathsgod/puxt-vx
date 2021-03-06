<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-06 
 */
return new class
{
    function post(VX $vx)
    {

        $base = dirname($vx->_post["path"]);
        $target = $base . DIRECTORY_SEPARATOR . $vx->_post["name"];

        $fs = $vx->getFileSystem();
        $fs->move($vx->_post["path"], $target);

        return [
            "label"=>$vx->_post["name"],
            "path"=>$target
        ];
    }
};
