<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-05 
 */

use Carbon\Carbon;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\FileAttributes;
use League\Flysystem\StorageAttributes;
use VX\FileManager;

return new class
{
    function get(VX $vx)
    {

        $deep = false;
        if ($search = $vx->_get["search"]) {
            $deep = true;
        }

        $fs = $vx->getFileManager();

        $folders = $fs->listContents($vx->_get["path"] ?? "/", $deep)->filter(function (StorageAttributes $attr) {
            return $attr->isDir();
        });

        if ($search) {
            $folders = $folders->filter(function (DirectoryAttributes $attr) use ($search) {
                $path = $attr->path();

                if (stristr(basename($path), $search) === false) {
                    return false;
                }
                return true;
            });
        }

        $folders = $folders->map(function (StorageAttributes $attr) {
            $mtime = Carbon::createFromTimestamp($attr->lastModified());
            return [
                "name" => basename($attr->path()),
                "path" => $attr->path(),
                "last_modified" => $mtime->format("Y-m-d"),
                "last_modified_human" => (string)$mtime->diffForHumans(),
                "size" => ""
            ];
        })->toArray();




        $files = $fs->listContents($vx->_get["path"] ?? "/", $deep)->filter(function (StorageAttributes $attr) {
            return $attr->isFile();
        });

        if ($vx->_get["file_type"]) {
            $mime_types = FileManager::LookupMimeType($vx->_get["file_type"]);

            $files = $files->filter(
                function (FileAttributes $attr) use ($fs, $mime_types) {
                    return in_array($fs->mimeType($attr->path()), $mime_types);
                }
            );
        }

        if ($search) {
            $files = $files->filter(function (FileAttributes $attr) use ($search) {
                $path = $attr->path();
                return stristr(basename($path), $search) !== false;
            });
        }



        $files = $files->map(function (FileAttributes $attr) use ($fs) {
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
                "mime_type" => $fs->mimeType($attr->path())
            ];
        })->toArray();

        $parent = dirname($vx->_get["path"]);
        if ($parent == ".") {
            $parent = "";
        }


        return [
            "parent" => $parent,
            "path" => $vx->_get["path"],
            "folders" => $folders,
            "files" => $files
        ];
    }
};
