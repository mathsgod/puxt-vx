{{table|raw}}
<?php

use VX\UserLog;

return [
    "get" => function (VX $context) {
        $rt = $context->createRTable("ds");
        $rt->add("ID", "userlog_id")->sortable()->searchable("equal");
        $rt->add("Login time", "login_dt")->sortable()->searchable("date");
        $rt->add("Logout time", "logout_dt")->sortable()->searchable("date");
        $rt->add("IP address", "ip")->ss();
        $rt->add("Result", "result")->sortable()->searchable("select")->searchOption(array("SUCCESS" => "SUCCESS", "FAIL" => "FAIL"));
        $rt->add("User agent", "user_agent")->searchable();
        $this->table = $rt;
    },
    "entries" => [
        "ds" => function (VX $vx) {

            $obj = $vx->object();
            $rt = $vx->createRTableResponse();
            $rt->source = UserLog::Query([
                "user_id" => $obj->user_id
            ]);

            return $rt;
        }
    ]
];
