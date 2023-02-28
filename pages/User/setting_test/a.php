<?php

/**
 * @author Raymond Chong
 * @date 2023-02-27 
 */

use VX\User;

return new class
{
    function get(VX $vx)
    {
        $schema = $vx->createSchema();

        //$schema->addQIcon("home")->size("xl");
        //$schema->addChildren("User/testing/a");

        $table = $schema->addQTable()->flat()->bordered()->square();
        $table->rowKey("user_id");
        $table->columns([
            [
                "label" => "ID",
                "field" => "user_id",
                //"sortable" => true
            ],
            [
                "label" => "Username",
                "field" => "username",
            ],
            [
                "label" => "Email",
                "field" => "email"
            ],
            [
                "label" => "First Name",
                "field" => "first_name"
            ],
            [
                "label" => "Last Name",
                "field" => "last_name"
            ],
            [
                "label" => "Phone",
                "field" => "phone"
            ],
            [
                "label" => "Status",
                "field" => "status"
            ]
        ]);
        $table->rows(User::Query()->toArray());


        return $schema;
    }
};
