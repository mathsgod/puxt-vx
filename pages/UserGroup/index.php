{{table|raw}}

<?php

use VX\UserGroup;

return new class
{
    function get(VX $vx)
    {
        $table = $vx->ui->createTable("data");

        $template = $table->addExpand();

        $template->innerHTML = "<div v-html='props.row.body'></div>";

        $table->addView();
        $table->addEdit();
        $table->addDel();
        $table->add("Name", "name")->sortable()->searchable();
        $table->add("Code", "code")->sortable()->searchable();
        $table->add("Num of users", "num_of_user");


        $this->table = $table;
    }

    function data(VX $vx)
    {
        $r = $vx->ui->createTableResponse();
        $r->source = UserGroup::Query();
        $r->add("name");
        $r->add("code");
        $r->add("num_of_user", function ($obj) {
            return $obj->User()->count();
        });
        return $r;
    }
};
