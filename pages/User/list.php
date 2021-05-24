{{table|raw}}
<?php


return [
    "get" => function (VX $context) {
        $rt = $context->createRTable();
        $rt->setAttribute("remote", "User/list?_action=ds");
        $rt->addView();
        $rt->add("Username", "username");
        $rt->add("First name", "first_name");
        $rt->add("Last name", "last_name");
        $this->table = $rt;
    },
    "action" => [
        "ds" => function (VX $context) {

            $rt = $context->createRTableResponse();
            $rt->source = VX\User::Query();
            return $rt;
        }
    ]
];
