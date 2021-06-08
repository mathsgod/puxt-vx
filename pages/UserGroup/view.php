{{tab|raw}}
<?php

use VX\UI\Tabs;

return ["get" => function (VX $context) {


    $tab = $context->createTab();
    $tab->setType(Tabs::TYPE_PILLS);
    $tab->add("Info", "view_info");
    $this->tab = $tab;
}];
