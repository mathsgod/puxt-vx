<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-06 
 */

use VX\FileManager;

return new class
{
    function post(VX $vx)
    {
        $file = $vx->request->getUploadedFiles()["file"];


        $name = $file->getClientFilename();
        $ext = pathinfo($name, PATHINFO_EXTENSION);

        if (in_array($ext, FileManager::$DisallowExt)) {
            throw new Exception("File extension not allowed", 400);
        }


        $fs = $vx->getFileManager();
        try {
            $fs->write($vx->_post["path"] . "/" . $file->getClientFilename(), $file->getStream()->getContents());
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 400);
        }


        $path = str_replace(DIRECTORY_SEPARATOR, "/", $vx->_post["path"]);


        if ($path != "") {
            $path .= "/";
        }

        return [
            "data" => [
                "name" => $name,
                "path" => $path . $name
            ]
        ];
    }
};
