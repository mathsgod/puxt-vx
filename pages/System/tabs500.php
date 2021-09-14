{{tab|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-09-14 
 */
return new class
{
    function get(VX $vx)
    {
        $tab = $vx->ui->createTabs();

        $tab->add("test", "show-500");

        $this->tab = $tab;
    }
};
