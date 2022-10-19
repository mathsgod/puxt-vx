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
        //get parent
        $parent = dirname($path);
        if ($parent == '\\') {
            $parent = "";
        }
        $parent .= "/";

        $target = $parent . $vx->_post["name"];

        $fs = $vx->getFileSystem();
        $fs->move($vx->_post["path"], $target);

        return [

            "name" => $vx->_post["name"],
            "path" => $target,
            "location" => $parent
        ];
    }
};
