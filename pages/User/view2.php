<vx-card>
    <vx-card-body>
        {{tab|raw}}
    </vx-card-body>
</vx-card>

<vx-card>
    <vx-card-body>
        {{tab2|raw}}
    </vx-card-body>
</vx-card>

<?php

use VX\UI\Tabs;

return ["get" => function (VX $vx) {
    $tab = $vx->ui->createTab();
    $tab->setType(Tabs::TYPE_PILLS);
    $tab->add("Info", "view_info");
    $tab->add("Edit", "ae");
    $this->tab = $tab;

    $tab2 = $vx->ui->createTab();
    $tab2->add("User log", "list_userlog");
    $this->tab2 = $tab2;
}];
