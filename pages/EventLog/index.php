{{table|raw}}
<?php

use VX\EventLog;

/**
 * Created by: Raymond Chong
 * Date: 2021-07-27 
 */
return new class
{
    function get(VX $vx)
    {
        $rt = $vx->ui->createTable("ds");
        $rt->setDefaultSort("eventlog_id","descending");
        //$rt->order("eventlog_id", "desc");
        $rt->addView();
        $rt->add("ID", "eventlog_id")->sortable()->searchable();
        $rt->add("Class", "class")->sortable()->searchable();
        $rt->add("Action", "action")->sortable()->searchable();
        $rt->add("Created time", "created_time");



        $this->table = $rt;
    }

    function ds(VX $vx)
    {
        $rt = $vx->ui->createTableResponse();
        $rt->source = EventLog::Query();
        $rt->add("eventlog_id");
        $rt->add("class");
        $rt->add("action");
        $rt->add("created_time");
        return $rt;
    }
};
