{{table|raw}}
<?php

use VX\User;
use VX\UserLog;

return new class
{
    function get(VX $context)
    {
        $rt = $context->ui->createTable("data");
        $rt->setDefaultSort("userlog_id", "descending");
        $rt->add("ID", "userlog_id")->sortable()->searchable()->width("60");
        $rt->add("User", "user_id");
        $rt->add("Login time", "login_dt")->sortable()->searchable("date");
        $rt->add("Logout time", "logout_dt")->sortable()->searchable("date");
        $rt->add("IP address", "ip")->sortable()->searchable();
        $rt->add("Result", "result")->sortable()->filterable([
            ["value" => "SUCCESS"],
            ["value" => "FAIL"]
        ]);
        $rt->add("User agent", "user_agent")->searchable();
        $this->table = $rt;
    }

    function data(VX $vx)
    {
        $rt = $vx->ui->createTableResponse();
        $rt->source = UserLog::Query();
        $rt->add("user_id", fn (UserLog $o) => $o->User());
        $rt->add("userlog_id");
        $rt->add("login_dt");
        $rt->add("logout_dt");
        $rt->add("ip");
        $rt->add("result");
        $rt->add("user_agent");
        return $rt;
    }
};
