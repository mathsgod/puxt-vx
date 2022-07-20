<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-08-16 
 */

use R\DB\Table as DBTable;

return new class
{
    function get(VX $vx)
    {
        $t = collect($vx->getDB()->getTables())->map(function (DBTable $t) {
            return [
                "name" => $t->name,
                "columns" => $t->columns()
            ];
        });
        return $t->toArray();
    }
};
