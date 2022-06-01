{{table|raw}}

<?php

use VX\UserGroup;
use VX\User;

return new class
{
    function get(VX $vx)
    {

        $table = $vx->ui->createTable("data");

        $table->addExpand()->append($this->getUserTable($vx));

        $action = $table->addActionColumn();
        $action->addView();
        $action->addEdit();
        $action->addDelete();

        $table->add("Name", "name")->sortable()->searchable();
        $table->add("Code", "code")->sortable()->searchable();
        $table->add("Num of users", "num_of_user");

        $this->table = $table;
    }

    function getUserTable(VX $vx)
    {
        $table = $vx->ui->createTable("getUserData");
        $ac = $table->addActionColumn();
        $ac->addView();

        $table->add("Username", "username");
        $table->add("First name", "first_name");
        $table->add("Last name", "last_name");

        $remote = $table->getAttribute("remote");
        $table->removeAttribute("remote");
        $table->setAttribute(":remote", "`$remote&usergroup_id=\${props.row.usergroup_id}`");

        return $table;
    }

    function getUserData(VX $vx)
    {
        $ug = UserGroup::Get($vx->_get["usergroup_id"]);
        $r = $vx->ui->createTableResponse();
        $r->source = $ug->User();
        $r->add("user_id");
        $r->add("username");
        $r->add("first_name");
        $r->add("last_name");
        return $r;
    }

    function data(VX $vx)
    {
        $r = $vx->ui->createTableResponse();
        $r->source = UserGroup::Query();
        $r->add("usergroup_id");
        $r->add("name");
        $r->add("code");
        $r->add("num_of_user", fn ($o) => $o->User()->count());
        return $r;
    }
};
