<?php

/**
 * @author Raymond Chong
 * @date 2023-02-08 
 */
return new class
{
    function get(VX $vx)
    {
        $schema = $vx->createSchema();

        $table = $schema->addVxTable();

        $table->query("User?fields[]=initial&fields[]=getStatus&fields[]=getRoles");
        $table->addColumn("Username", "username")->sortable()->searchable();

        $column = $table->addColumn();
        $column->addChildren('$row.initial');
        $avatar = $column->addComponent("QAvatar", [
            "color" => "primary",
            "text-color" => "white",
            "size" => "sm",
            "slots" => [
                "default" => [
                    "children" => '$row.initial'
                ]
            ]

        ]);
        $avatar->addChildren('$row.username');
        $column->addElement("div", [])->addChildren('$row.username');

        return $schema;
    }
};
