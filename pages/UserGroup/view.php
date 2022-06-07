<div class="mb-2">
    {{tab|raw}}
</div>

<div>
    {{user_table|raw}}
</div>

<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-09-10 
 */

use VX\UI\Tabs;
use VX\UserGroup;

return new class
{
    function get(VX $vx)
    {

        $tab = $vx->ui->createTabs();
        //$tab->setType(Tabs::TYPE_PILLS);
        $tab->add("Information", "view-info");
        $this->tab = $tab;

        $ut = $vx->ui->createTable("user");
        $ac = $ut->addActionColumn();
        $ac->addView();
        $ac->addEdit();
        $ac->addDelete();

        $ut->add("Username", "username");
        $ut->add("First name", "first_name");
        $ut->add("Last name", "last_name");
        $ut->add("Email", "email");

        $this->user_table = $ut;
    }

    function user(VX $vx)
    {
        $ug = UserGroup::FromGlobal();
        $rt = $vx->ui->createTableResponse();
        $rt->source = $ug->User();

        $rt->add("username");
        $rt->add("first_name");
        $rt->add("last_name");

        return $rt;
    }
};
