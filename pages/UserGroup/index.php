{{table|raw}}

<?php

use VX\UserGroup;
use VX\User;

return new class
{
    function get(VX $vx)
    {

        $user_table = $vx->ui->createTable("user_data");
        $user_table->add("First name", "first_name");

        $remote = $user_table->getAttribute("remote");
        $user_table->removeAttribute("remote");
        $user_table->setAttribute(":remote", "`$remote&usergroup_id=\${props.row.usergroup_id}`");

        $table = $vx->ui->createTable("data");

        $template = $table->addExpand();
        $template->append($user_table);

        $table->addView();
        $table->addEdit();
        $table->addDel();

        $table->add("Name", "name")->sortable();
        $table->add("Code", "code")->sortable();
        $table->add("Num of users", "num_of_user");


        $this->table = $table;
    }

    function user_data(VX $vx)
    {
        $ug = new UserGroup($vx->_get["usergroup_id"]);
        $r = $vx->ui->createTableResponse();
        $r->source = $ug->User();
        $r->add("first_name");
        return $r;
    }

    function data(VX $vx)
    {
        $r = $vx->ui->createTableResponse();
        $r->source = UserGroup::Query();

        $r->add("usergroup_id");
        $r->add("name");
        $r->add("code");
        $r->add("num_of_user", function ($obj) {
            return $obj->User()->count();
        });
        return $r;
    }
};
