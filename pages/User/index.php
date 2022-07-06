<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-06-21 
 */

use VX\User;

return new class
{
    function get(VX $vx)
    {
        $table = $vx->ui->createTable();
        $table->add("First name", "first_name")->sortable()->searchable();
        $table->add("Last name", "last_name")->sortable()->searchable();

        $table->setData(User::Query());
        return $table;
    }
};
