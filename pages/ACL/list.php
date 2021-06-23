{{table|raw}}
<?php

use VX\ACL;

return [
    "get" => function (VX $vx) {
        $rt = $vx->ui->createRTable("ds");
        $rt->order("user_id", "desc");

        $rt->addDel();
        $rt->add("Module", "module")->ss();
        $rt->Add("Path", "path")->ss();
        $rt->Add("Action", "action")->ss();
        $rt->Add("User", "user_id");
        $rt->Add("UserGroup", "usergroup_id");
        $rt->Add("Special User", "special_user");
        $rt->Add("Value", "value")->sortable();
        $rt->add("Type", "type")->sortable();


        $this->table = $rt;
    },
    "entries" => [
        "ds" => function (VX $vx) {

            $rt = $vx->ui->createRTableResponse();
            $rt->source = ACL::Query();
            $rt->add("usergroup_id", "UserGroup()");
            return $rt;
        }
    ]
];
