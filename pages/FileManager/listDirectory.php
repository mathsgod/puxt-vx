<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-05 
 */

use League\Flysystem\StorageAttributes;

return new class
{

    function get(VX $vx)
    {
        $fs = $vx->getFileManager();

        $ret = $fs->listContents($vx->_get["path"] ?? "/")->filter(function (StorageAttributes $attr) {

            return $attr->isDir();
        })->map(function (StorageAttributes $attr) {

            return [
                "label" => basename($attr->path()),
                "path" => $attr->path()
            ];
        })->toArray();

        return $ret;
    }
};
