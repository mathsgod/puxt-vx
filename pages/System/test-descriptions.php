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

use P\HTMLTemplateElement;
use VX\UI\Descriptions;

return new class
{
    function get(VX $vx)
    {
        $view = $vx->ui->createDescriptions($vx->user);
        $view->setTitle("Description title");
        $view->add("username", "username");
        $view->add("First name", "first_name");
        $view->add("ABC DEf", "first_name");

        $view->add("Subject", "subject");

        $view->setExtraTemplate(function (HTMLTemplateElement $t) {
            $t->innerHTML = "hello ";
        });

        $view->setExtraTemplate(function (HTMLTemplateElement $t) {
            $t->innerHTML = "hello 2";
        });

        $this->desc = $view;
    }
};
