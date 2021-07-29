{{table|raw}}
<?php

use VX\ACL;

return new class
{
    public function get(VX $vx)
    {

        $table = $vx->ui->createTable("ds");

        $a = $table->addActionColumn();
        $a->addDelete();

        $table->add("Module", "module")->sortable()->searchable();
        $table->Add("Path", "path")->sortable()->searchable();
        $table->Add("Action", "action")->sortable()->searchable();
        $table->Add("User", "user_id");
        $table->Add("UserGroup", "usergroup_id");
        $table->Add("Special User", "special_user");
        $table->Add("Value", "value")->sortable();
        $table->add("Type", "type")->sortable();

        $this->table = $table;
    }

    public function ds(VX $vx)
    {
        $rt = $vx->ui->createTableResponse();
        $rt->source = ACL::Query();
        $rt->add("usergroup_id", "UserGroup()");
        $rt->add("module");
        $rt->add("path");
        $rt->add("action");
        $rt->add("user_id");
        $rt->add("special_user");
        $rt->add("value");
        $rt->add("type");
        return $rt;
    }
};
