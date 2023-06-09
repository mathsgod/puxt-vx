<?php

/**
 * @author Raymond Chong
 * @date 2023-06-09 
 */

use Laminas\Diactoros\ResponseFactory;
use League\Flysystem\StorageAttributes;
use Symfony\Contracts\Translation\TranslatorInterface;

return new class
{
    function download(VX $vx)
    {
        $index = $vx->_get["index"];
        $fs = $vx->getFileSystem($index);

        if ($fs) {
            $files = $fs->listContents("/", true)->filter(function (StorageAttributes $attr) {
                return $attr->isFile();
            })->toArray();


            //create temp file for zip
            $temp_file = tempnam(sys_get_temp_dir(), "vx");

            //create zip file
            $zip = new ZipArchive();
            $zip->open($temp_file, ZipArchive::CREATE);

            foreach ($files as $file) {
                $zip->addFromString($file->path(), $fs->read($file->path()));
            }

            $zip->close();

            $resp = (new ResponseFactory)->createResponse();
            $resp->getBody()->write(file_get_contents($temp_file));
            $resp = $resp->withHeader("Content-Type", "application/octet-stream");
            $resp = $resp->withHeader("Content-Disposition", "attachment; filename=download.zip");
            $resp = $resp->withHeader("Content-Length", filesize($temp_file));
            $resp = $resp->withHeader("Pragma", "no-cache");
            $resp = $resp->withHeader("Expires", "0");


            return $resp;
        }
    }

    function get(VX $vx, TranslatorInterface $translator)
    {
        $schema = $vx->createSchema();

        $fm = [];
        $i = 0;
        while ($_ENV["VX_FILE_MANAGER_{$i}"]) {
            $fm[] = [
                "type" => $_ENV["VX_FILE_MANAGER_{$i}"],
                "download" => "/api/System/filesystem?_entry=download&index=$i"
            ];
            $i++;
        }

        if (count($fm) == 0) {
            $fm[] = ["type" => "local", "download" => "/api/System/filesystem?_entry=download&index=0"];
        }

        $table = $schema->addElTable();
        $table->data($fm);
        $table->addColumn()->label("Type")->prop("type");

        $column = $table->addColumn()->label("Action")->prop("action");

        $a = $column->addElement("a")->attr("href", '$row.download');;
        $a->addButton("Download")->type("primary")->icon("el-icon-download");




        return $schema;
    }
};
