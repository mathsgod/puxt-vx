{{table|raw}}
<?php

use VX\User;
use VX\UserLog;

return [
    "get" => function (VX $context) {
        $rt = $context->createRTable();
        $rt->setAttribute("remote", "UserLog/list?_action=ds");
        $rt->add("ID", "userlog_id")->sortable()->searchable("equal");
        $rt->add("User", "user_id")->searchOption(User::Query());
        $rt->add("Login time", "login_dt")->sortable()->searchable("date");
        $rt->add("Logout time", "logout_dt")->sortable()->searchable("date");
        $rt->add("IP address", "ip")->ss();
        $rt->add("Result", "result")->sortable()->searchable("select")->searchOption(array("SUCCESS" => "SUCCESS", "FAIL" => "FAIL"));
        $rt->add("User agent", "user_agent")->searchable();
        $this->table = $rt;
    },
    "action" => [
        "ds" => function (VX $context) {

            $rt = $context->createRTableResponse();
            $rt->source = UserLog::Query();
            $rt->add("user_id", "User()");
            return $rt;
        }
    ]
];
