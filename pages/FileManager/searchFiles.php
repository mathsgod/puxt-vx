<?php

/**
 * @author: Raymond Chong
 * Date: 2022-10-19
 */

use Carbon\Carbon;
use League\Flysystem\FileAttributes;
use League\Flysystem\StorageAttributes;
use VX\FileManager;

return new class
{
    function get(VX $vx)
    {
        if ($vx->_get["type"]) {
            $type = FileManager::LookupMimeType($vx->_get["type"]);
        }


        $fs = $vx->getFileSystem();
        $parent = $vx->_get["path"] ?? "/";

        return $fs->listContents($parent, true)->filter(function (StorageAttributes $attr) use ($fs, $type) {
            if ($attr->isFile()) {
                if ($type) {
                    return in_array($fs->mimeType($attr->path()), $type);
                }
                return true;
            }
        })->map(function (FileAttributes $attr) use ($fs) {
            $mtime = Carbon::createFromTimestamp($attr->lastModified());
            $filename = basename($attr->path());
            return [
                "name" => $filename,
                "path" => $attr->path(),
                "size" => $attr->fileSize(),
                "size_display" => FileManager::FormatBytes($attr->fileSize()),
                "last_modified" => $mtime->format("Y-m-d"),
                "last_modified_human" => (string)$mtime->diffForHumans(),
                "extension" => pathinfo($filename, PATHINFO_EXTENSION),
                "mime_type" => $fs->mimeType($attr->path()),
                "type" => $attr->type()

            ];
        })->toArray();
    }
};
