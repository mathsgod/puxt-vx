<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-06 
 */

use Carbon\Carbon;
use League\Flysystem\FileAttributes;
use League\Flysystem\StorageAttributes;

return new class
{
    function get(VX $vx)
    {
        $fs = $vx->getFileSystem();
        $ret = $fs->listContents("", true)->filter(function (StorageAttributes $attr) use ($fs) {
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

        usort($ret, function ($a, $b) {
            return $b["last_modified"] <=> $a["last_modified"];
        });

        return array_slice($ret, 0, 100);
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
