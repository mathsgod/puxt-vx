<?php

/**
 * @author Raymond Chong
 * @date 2023-02-01 
 */
return new class
{
    function get(VX $vx)
    {
        $schema = $vx->createSchema();

        $table = $schema->addVxTable();
        $table->query("UserLog?populate[User][fields][]=first_name?sort[]=userlog_id:desc");
        $table->addColumn("ID", "userlog_id")->sortable()->width(100)->searchable();

        $table->addColumn("User", "User.first_name");
        $table->addColumn("Login time", "login_dt")->sortable()->searchable()->searchType("date");
        $table->addColumn("Logout time", "logout_dt")->sortable()->searchable()->searchType("date");

        $table->addColumn("IP", "ip")->sortable()->searchable();
        $table->addColumn("Result", "result")->searchable()->searchType("select")->searchOptions([
            ["value" => "Success", "label" => "Success"],
            ["value" => "Fail", "label" => "Fail"]
        ]);
        $table->addColumn("User agent", "user_agent")->sortable()->searchable();


        return $schema;
    }
};
