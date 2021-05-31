{{table|raw}}
<?php

use VX\UserGroup;

return [
    "get" => function (VX $context) {
        $rt = $context->createRTable("ds");
        $rt->addView();
        $rt->addEdit();
        $rt->addDel();
        $rt->add("Name", "name")->ss();
        $this->table = $rt;
    },
    "entries" => [
        "ds" => function (VX $context) {

            $rt = $context->createRTableResponse();
            $rt->source = UserGroup::Query();
            return $rt;
        }
    ]
];
