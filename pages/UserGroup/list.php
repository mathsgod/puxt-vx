{{table|raw}}
<?php

use VX\UserGroup;

return [
    "get" => function (VX $context) {
        $rt = $context->createRTable();
        $rt->setAttribute("remote", "UserGroup/list?_action=ds");
        $rt->addView();
        $rt->addDel();
        $rt->add("Name", "name")->ss();
        $this->table = $rt;
    },
    "action" => [
        "ds" => function (VX $context) {

            $rt = $context->createRTableResponse();
            $rt->source = UserGroup::Query();
            return $rt;
        }
    ]
];
