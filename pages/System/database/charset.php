<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-07-08 
 */
return new class
{

    function changeToDefault(VX $vx)
    {
        $error = [];

        foreach ($vx->getDB()->getTables() as $table) {
            foreach ($table->columns() as $column) {
                if (
                    strtolower(substr($column->Type, 0, 7)) == "varchar" ||
                    strtolower($column->Type) == "text" ||
                    strtolower($column->Type) == "longtext"
                ) {

                    $field = $column->Field;
                    $type = $column->Type;
                    $t = $table->name;
                    $sql = "ALTER TABLE  `$t` CHANGE COLUMN `{$field}` `{$field}` {$type} NULL DEFAULT NULL;";

                    try {
                        $vx->getDB()->exec($sql);
                    } catch (Exception $e) {
                        $error[] = $sql;
                        $error[] = $e->getMessage();
                    }
                }
            }
        }
        if ($error) {
            return ["error" => [
                "message" => implode("\n", $error)
            ]];
        }
    }

    function post(VX $vx)
    {
        $charset = $vx->_post['charset'];
        $collation = $vx->_post['collation'];

        $error = [];
        foreach ($vx->getDB()->getTables() as $table) {
            $t = $table->name;
            $sql = "ALTER TABLE  `$t` DEFAULT CHARACTER SET {$charset} COLLATE {$collation};";
            try {
                $vx->getDB()->exec($sql);
            } catch (Exception $e) {
                $error[] = $e->getMessage();
            }
        }

        if ($error) {
            return ["error" => [
                "message" => implode("\n", $error)
            ]];
        }
    }

    function get(VX $vx)
    {
        $data = $vx->getDB()->query("SELECT @@character_set_database, @@collation_database")->fetch();

        return [
            "view" => $data,
            "table" => $vx->getDB()->query("SHOW TABLE STATUS")->fetchAll()
        ];
    }


    function changeColumn()
    {
    }
};
