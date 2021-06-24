{{table|raw}}
<?php

use VX\User;
use VX\UserLog;

return new class
{
    function get(VX $context)
    {
        $rt = $context->ui->createRTable("ds");
        $rt->add("ID", "userlog_id")->sortable()->searchable("equal");
        $rt->add("User", "user_id")->searchOption(User::Query());
        $rt->add("Login time", "login_dt")->sortable()->searchable("date");
        $rt->add("Logout time", "logout_dt")->sortable()->searchable("date");
        $rt->add("IP address", "ip")->ss();
        $rt->add("Result", "result")->sortable()->searchable("select")->searchOption(array("SUCCESS" => "SUCCESS", "FAIL" => "FAIL"));
        $rt->add("User agent", "user_agent")->searchable();
        $this->table = $rt;
    }

    function ds(VX $context)
    {

        $rt = $context->ui->createRTableResponse();
        $rt->source = UserLog::Query();
        $rt->add("user_id", "User()");
        return $rt;
    }
};
