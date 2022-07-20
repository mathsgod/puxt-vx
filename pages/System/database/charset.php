<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-07-08 
 */
return new class
{
    function get(VX $vx)
    {
        $data = $vx->getDB()->query("SELECT @@character_set_database, @@collation_database")->fetch();

        return [
            "view" => $data,
            "table" => $vx->getDB()->query("SHOW TABLE STATUS")->fetchAll()
        ];
    }
};
