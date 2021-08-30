{{table|raw}}
<?php

use VX\Config;

/**
 * Created by: Raymond Chong
 * Date: 2021-08-30 
 */
return new class
{
    function get(VX $vx)
    {

        $rt = $vx->ui->createRTable("ds");
        $rt->addEdit();
        $rt->addDel();
        $rt->add("Name", "name")->sortable();
        $rt->add("Value", "value")->sortable();
        $this->table = $rt;
    }

    function ds(VX $vx)
    {
        $rt = $vx->ui->createRTableResponse();
        $rt->source = Config::Query();
        return $rt;
    }
};
