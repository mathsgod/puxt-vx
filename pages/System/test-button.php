{{button_group}}
<vue>
    {{button_group|raw}}
</vue>

<?php
/**
 * Created by: Raymond Chong
 * Date: 2021-10-08 
 */

use VX\UI\EL\ButtonGroup;

return new class
{
    function get(VX $vx)
    {
        $bg = new ButtonGroup;
        $b = $bg->addButton();
        $b->textContent = "btn1";

        $b->setType("primary");


        $b2 = $bg->addButton();
        $b2->textContent = "btn2";
        $b2->setLoading(true);

        $b3 = $bg->addButton();
        $b3->textContent = "btn3";
        $b3->setIcon("el-icon-user");

        $b4 = $bg->addButton();
        $b4->setRound(true);
        $b4->textContent = "btn4";
        $b4->setIcon("el-icon-user");

        $this->button_group = $bg;
    }
};
