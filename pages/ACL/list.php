{{table|raw}}
<?php

use VX\ACL;

return [
    "get" => function (VX $context) {
        $rt = $context->createRTable("ds");
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
        "ds" => function (VX $context) {

            $rt = $context->createRTableResponse();
            $rt->source = ACL::Query();
            return $rt;
        }
    ]
];
