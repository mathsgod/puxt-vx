<vx-card>
    <vx-card-body>
        {{tab|raw}}
    </vx-card-body>
</vx-card>

<?php

use VX\UI\Tabs;

return ["get" => function (VX $context) {
    $tab = $context->createTab();
    $tab->setType(Tabs::TYPE_PILLS);
    $tab->add("Info", "view_info");


    $tab->add("Edit", "ae");


    $this->tab = $tab;
}];
