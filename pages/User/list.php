{{table|raw}}
<?php


return [
    "get" => function (VX $context) {
        $rt = $context->createRTable("ds");
        //$rt->setAttribute("remote", "User/list?_entry=ds");
        $rt->addView();
        $rt->addEdit();
        $rt->addDel();
        $rt->add("Username", "username")->ss();
        $rt->add("First name", "first_name")->ss();
        $rt->add("Last name", "last_name")->ss();
        $rt->add("Phone", "phone")->ss();
        $rt->add("Email", "email")->ss();
        $rt->add("Join date", "join_date");
        $rt->add("Language", "language");
        $this->table = $rt;
    },
    "entries" => [
        "ds" => function (VX $context) {
            $rt = $context->createRTableResponse();
            $rt->source = VX\User::Query();
            return $rt;
        }
    ],
];
