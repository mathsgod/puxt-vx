<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-05 
 */

use Carbon\Carbon;
use League\Flysystem\FileAttributes;
use League\Flysystem\StorageAttributes;

return new class
{
    function get(VX $vx)
    {

        $fs = $vx->getFileManager();

        $folders = $fs->listContents($vx->_get["path"] ?? "/")->filter(function (StorageAttributes $attr) {
            return $attr->isDir();
        })->map(function (StorageAttributes $attr) {
            $mtime = Carbon::createFromTimestamp($attr->lastModified());
            return [
                "name" => basename($attr->path()),
                "path" => $attr->path(),
                "last_modified" => $mtime->format("Y-m-d"),
                "last_modified_human" => (string)$mtime->diffForHumans(),
                "size" => ""
            ];
        })->toArray();

        $files = $fs->listContents($vx->_get["path"] ?? "/")->filter(function (StorageAttributes $attr) {
            return $attr->isFile();
        })->map(function (FileAttributes $attr) use ($fs) {

            $mtime = Carbon::createFromTimestamp($attr->lastModified());

            $filename = basename($attr->path());


            return [
                "name" => $filename,
                "path" => $attr->path(),
                "size" => $attr->fileSize(),
                "size_display" => $this->FormatBytes($attr->fileSize()),
                "last_modified" => $mtime->format("Y-m-d"),
                "last_modified_human" => (string)$mtime->diffForHumans(),
                "extension" => pathinfo($filename, PATHINFO_EXTENSION),
                "mime_type" => $fs->mimeType($attr->path())
            ];
        })->toArray();



        return ["folders" => $folders, "files" => $files];
    }



    private function FormatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
};
