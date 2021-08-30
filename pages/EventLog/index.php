{{table|raw}}
<?php

use VX\EventLog;
use VX\UI\TableColumn;

/**
 * Created by: Raymond Chong
 * Date: 2021-07-27 
 */
return new class
{
    function get(VX $vx)
    {
        $rt = $vx->ui->createTable("ds");
        $rt->setDefaultSort("eventlog_id", "descending");
        //$rt->order("eventlog_id", "desc");
        $action = $rt->addActionColumn();
        $action->addView();

        $rt->add("ID", "eventlog_id")->sortable()->searchable();
        $rt->add("Class", "class")->sortable()->searchable();
        $rt->add("Action", "action")->sortable()->searchable();
        $rt->add("Created time", "created_time");
  //      $rt->add("Created by", "created_by")->searchable(TableColumn::SEARCH_TYPE_SELECT);
//


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
        $rt->add("created_by", fn (EventLog $e) => $e->User());
        return $rt;
    }
};
