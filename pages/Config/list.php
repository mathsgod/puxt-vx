{{table|raw}}
<?php

use VX\Config;

return [
    "get" => function (VX $context) {

        $rt = $context->ui->createRTable("ds");
        $rt->addEdit();
        $rt->addDel();
        $rt->add("Name", "name")->sortable();
        $rt->add("Value", "value")->sortable();
        $this->table = $rt;
    },
    "entries" => [
        "ds" => function (VX $context) {

            $rt = $context->ui->createRTableResponse();
            $rt->source = Config::Query();
            return $rt;
        }
    ]
];
