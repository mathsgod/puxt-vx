<?php

/**
 * @author Raymond Chong
 * @date 2023-01-19 
 */
return new class
{
    function get(VX $vx)
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
};
