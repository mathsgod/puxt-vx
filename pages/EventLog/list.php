{{table|raw}}
<?php

use VX\EventLog;

return [
    "get" => function (VX $context) {
        $rt = $context->createRTable("ds");
        $rt->addView();
        $rt->add("ID", "eventlog_id");
        $this->table = $rt;
    },
    "entries" => [
        "ds" => function (VX $context) {

            $rt = $context->createRTableResponse();
            $rt->source = EventLog::Query();
            return $rt;
        }
    ]
];
