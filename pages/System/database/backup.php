<?php

/**
 * @author Raymond Chong
 * @date 2023-01-19 
 */

use Psr\Http\Message\ServerRequestInterface;

return new class
{
    function download(VX $vx)
    {
        header("Content-Type: text/plain");
        header("Content-Disposition: attachment; filename=backup.sql");

        //create tmp file
        $tmp = tempnam(sys_get_temp_dir(), "vx");

        $schema = $vx->getDB();

        $schema->backup($tmp);

        readfile($tmp);
        unlink($tmp);
        die();
    }

    function get(VX $vx, ServerRequestInterface $request)
    {

        $uri = $request->getUri();
        $uri = $uri->withQuery("_entry=download");

        $schema = $vx->createSchema();
        $a = $schema->addElement("a")->attr("href", $uri->__toString());

        $a->addButton("Download")->type("primary")->icon("el-icon-download");
        return $schema;
    }
};
