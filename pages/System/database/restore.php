<?php

/**
 * @author Raymond Chong
 * @date 2023-01-19 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\UploadedFileInterface;

return new class
{
    function get(VX $vx)
    {
    }

    function post(VX $vx)
    {
        $file = $vx->_files["file"];


        if ($file->getError() != UPLOAD_ERR_OK) {
            switch ($file->getError()) {
                case UPLOAD_ERR_INI_SIZE:
                    throw new Exception("File size too large");
                case UPLOAD_ERR_FORM_SIZE:
                    throw new Exception("File size too large");
                case UPLOAD_ERR_PARTIAL:
                    throw new Exception("File upload incomplete");
                case UPLOAD_ERR_NO_FILE:
                    throw new Exception("No file uploaded");
                case UPLOAD_ERR_NO_TMP_DIR:
                    throw new Exception("No temp directory");
                case UPLOAD_ERR_CANT_WRITE:
                    throw new Exception("Cannot write to disk");
                case UPLOAD_ERR_EXTENSION:
                    throw new Exception("File upload stopped by extension");
            }
            throw new Exception("Upload error");
        }

        //get stream uri
        $uri = $file->getStream()->getMetadata('uri');


        $db = $vx->getDB();
        $db->restore($uri);

        return new EmptyResponse();
    }
};
