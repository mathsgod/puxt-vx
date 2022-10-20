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
        $fs = $vx->getFileSystem();

        $parent = $vx->_get["path"];
        $parent = $vx->normalizePath($parent);

        $ret = $fs->listContents($parent)->filter(function (StorageAttributes $attr) {
            return $attr->isDir();
        })->map(function (StorageAttributes $attr) use ($parent, $vx) {

            $path = $attr->path();
            return [
                "name" => basename($path),
                "path" => $vx->normalizePath($path),
                "location" => $parent,
                "last_modified" => $attr->lastModified(),
            ];
        })->toArray();

        return $ret;
    }
};
