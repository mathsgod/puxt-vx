{{table|raw}}
<?php

use VX\EventLog;

return [
    "get" => function (VX $vx) {
        $rt = $vx->ui->createRTable("ds");
        $rt->order("eventlog_id", "desc");
        $rt->addView();
        $rt->add("ID", "eventlog_id")->ss();
        $rt->add("Class", "class")->ss();
        $rt->add("Action", "action")->ss();
        $rt->add("Created time", "created_time");



        $this->table = $rt;
    },
    "entries" => [
        "ds" => function (VX $vx) {

            $rt = $vx->ui->createRTableResponse();
            $rt->source = EventLog::Query();
            return $rt;
        }
    ]
];
