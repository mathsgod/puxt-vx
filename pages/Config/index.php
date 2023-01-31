<?php

/**
 * @author Raymond Chong
 * @date 2023-01-30 
 */
return new class
{
    function get(VX $vx)
    {
        $schema = $vx->createSchema();
        $table = $schema->addVxTable();
        $table->query("Config");

        $table->addActionColumn()->showDelete()->showEdit();

        $table->addColumn()->label("Name")->prop("name")->sortable()->searchable();
        $table->addColumn()->label("Value")->prop("value")->sortable()->searchable();

        return $schema;
    }
};
