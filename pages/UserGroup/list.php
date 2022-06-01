{{table|raw}}
<?php

use VX\UserGroup;

/**
 * Created by: Raymond Chong
 * Date: 2022-05-30 
 */
return new class
{
    function get(VX $vx)
    {
        $rt = $vx->ui->createRTable("ds");
        $rt->addView();
        $rt->addEdit();
        $rt->addDel();
        $rt->add("Name", "name")->ss();
        $rt->add("Code", "code")->ss();
        $rt->add("Num of user", "num_of_user");
        $this->table = $rt;
    }

    function ds(VX $vx)
    {
        $rt = $vx->ui->createRTableResponse();
        $rt->source = UserGroup::Query();
        $rt->add("num_of_user", function ($o) {
            return $o->User()->count();
        });
        return $rt;
    }
};
