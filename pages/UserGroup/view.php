{{tab|raw}}
{{user_table|raw}}
<?php

use VX\UI\Tabs;

return ["get" => function (VX $vx) {


    $tab = $vx->ui->createTab();
    $tab->setType(Tabs::TYPE_PILLS);
    $tab->add("Info", "view_info");
    $this->tab = $tab;


    $ut = $vx->ui->createRTable("user");
    $ut->add("Username", "username");

    $this->user_table = $ut;
}, "entries" => [
    "user" => function (VX $vx) {
        $rt = $vx->ui->createRTableResponse();
        $rt->source = $vx->object()->User();

        return $rt;
    }
]];
