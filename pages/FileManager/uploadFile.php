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
            http_response_code(400);
            return ["error" => ["message" => "extension not allow"]];
        }


        $fs = $vx->getFileManager();
        try {
            $fs->write($vx->_post["path"] . "/" . $file->getClientFilename(), $file->getStream()->getContents());
        } catch (Exception $e) {
            http_response_code(400);

            return ["error" => ["message" => $e->getMessage()]];
        }
    }
};
