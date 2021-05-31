<vx-card>
    <vx-card-body>
        <vx-tabs type="pills">
            <vx-tab label="Info" link="UserGroup/1/view_info" active></vx-tab>
            <vx-tab label="ACL" link="UserGroup/1/acl_edit"></vx-tab>
        </vx-tabs>
    </vx-card-body>
</vx-card>
<?php

use VX\UI\Tabs;

return ["get" => function (VX $context) {

    $tab = $context->createTab();
    $tab->setType(Tabs::TYPE_PILLS);
    $this->tab = $tab;

    

    $view = $context->createView($context->object());
    $view->add("Name", "name");

    $this->view = $view;
}];
