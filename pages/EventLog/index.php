{{table|raw}}
<?php

use Laminas\Db\Sql\Where;
use VX\EventLog;
use VX\UI\EL\Select;
use VX\UI\TableColumn;
use VX\User;

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
        $rt->add("Created by", "user_id")->searchable(TableColumn::SEARCH_TYPE_SELECT, function ($select) {
            $select->option(User::Query(), "username", "user_id");
        });
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
        $rt->add("user_id", fn (EventLog $e) => $e->User()?->__toString());


        return $rt;
    }
};
