{{table|raw}}
<?php

use VX\User;
use VX\UserLog;

return new class
{
    function get(VX $context)
    {
        $rt = $context->ui->createTable("data");
        $rt->setDefaultSort("userlog_id", "desc");
        $rt->add("ID", "userlog_id")->sortable()->searchable()->width("60");
        $rt->add("User", "user");
        $rt->add("Login time", "login_dt")->sortable()->searchable("date");
        $rt->add("Last access", "last_access_time")->sortable();
        $rt->add("Logout time", "logout_dt")->sortable()->searchable("date");

        $rt->add("IP address", "ip")->sortable()->searchable();
        $rt->add("Result", "result")->sortable()->filterable([
            [
                "value" => "SUCCESS",
                "text" => "SUCCESS"
            ],
            [
                "value" => "FAIL",
                "text" => "FAIL"
            ]
        ]);
        $rt->add("User agent", "user_agent")->searchable()->overflow();
        $this->table = $rt;
    }

    function data(VX $vx)
    {
        $rt = $vx->ui->createTableResponse();
        $rt->source = UserLog::Query();
        $rt->add("userlog_id");
        $rt->add("user", fn (UserLog $o) => $o->User()?->__toString());
        $rt->add("login_dt");
        $rt->add("logout_dt");
        $rt->add("last_access_time");
        $rt->add("ip");
        $rt->add("result");
        $rt->add("user_agent");
        return $rt;
    }
};
