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
        $table->query("EventLog?sort[]=eventlog_id:desc");

        $table->addActionColumn()->showView();

        $table->addColumn("ID", "eventlog_id")->sortable()->width(100);
        $table->addColumn("Class", "class")->sortable()->searchable();
        $table->addColumn("Action", "action")->sortable()->searchable();
        $table->addColumn("Created time", "created_time")->sortable()->searchable();
        $table->addColumn("Created by", "User.username")->sortable()->searchable();

        return $schema;
    }
};
