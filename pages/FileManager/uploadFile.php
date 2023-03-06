<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-06 
 */

use Psr\Http\Message\ServerRequestInterface;
use VX\FileManager;
use VX\FileManager\Event\BeforeUploadFile;

return new class
{
    function post(VX $vx, ServerRequestInterface $request)
    {
        $file = $request->getUploadedFiles()["file"];

        if (!$file) {
            throw new Exception("No file uploaded", 400);
        }

        $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);

        if (in_array($ext, FileManager::$DisallowExt)) {
            throw new Exception("File extension not allowed", 400);
        }

        $event = new BeforeUploadFile($file);
        $vx->eventDispatcher()->dispatch($event);
        $file = $event->target;
        $fs = $vx->getFileSystem();


        $path = $vx->_post["path"];

        $name = $file->getClientFilename();
        $target = $path . "/" . $name;

        try {
            $fs->write($target, $file->getStream()->getContents());
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 400);
        }

        return [
            "name" => $name,
            "path" => $vx->normalizePath($target),
            "location" => $vx->normalizePath($path),
            "last_modified" => $fs->lastModified($target),
            "size" => $fs->fileSize($target),
            "type" => $fs->mimeType($target),
            "extention" => $ext,
            "mime_type" => $fs->mimeType($target),
        ];
    }
};
