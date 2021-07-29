{{table|raw}}
<?php

use VX\Config;

/**
 * Created by: Raymond Chong
 * Date: 2021-07-19 
 */
return new class
{
    function get(VX $vx)
    {
        $table = $vx->ui->createTable("data");
        $action = $table->addActionColumn();
        $action->addEdit();
        $action->addDelete();
        
        $table->add("Name", "name")->sortable()->searchable();
        $table->add("Value", "value")->sortable();
        $this->table = $table;
    }

    function data(VX $vx)
    {
        $resp = $vx->ui->createTableResponse();
        $resp->source = Config::Query();
        $resp->add("name");
        $resp->add("value");
        return $resp;
    }
};
