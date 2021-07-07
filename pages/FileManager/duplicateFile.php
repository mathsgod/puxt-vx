<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-06 
 */
return new class
{
    function post(VX $vx)
    {

        $fs = $vx->getFileManager();

        $source = $vx->_post["path"];
        $ext = pathinfo($source, PATHINFO_EXTENSION);

        $path = substr($source, 0, -strlen($ext) - 1);

        $i = 1;
        do {
            $new = $path . " ($i)." . $ext;
            $i++;
        } while ($fs->fileExists($new));

        $fs->copy($source, $new);
    }
};
