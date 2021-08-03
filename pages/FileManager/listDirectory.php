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

        $parent = $vx->_get["path"] ?? "/";
        $ret = $fs->listContents($parent)->filter(function (StorageAttributes $attr) {

            return $attr->isDir();
        })->map(function (StorageAttributes $attr) use ($parent) {

            return [
                "label" => basename($attr->path()),
                "path" => $attr->path(),
                "location" => $parent
            ];
        })->toArray();

        return $ret;
    }
};
