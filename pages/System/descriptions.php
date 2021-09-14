<vue>
    <el-card>
        {{desc|raw}}
    </el-card>
    {{desc}}

</vue>
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-09-14 
 */

use VX\UI\Descriptions;

return new class
{
    function get(VX $vx)
    {
        $view = $vx->ui->createDescriptions($vx->user);
        $view->add("username", "username");
        $view->add("First name", "first_name");
        $view->add("ABC DEf", "first_name");

        $view->add("Subject","subject");

        $this->desc = $view;
    }
};
