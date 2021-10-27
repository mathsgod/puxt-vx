<vue>
    {{menu|raw}}
</vue>

<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-10-27 
 */
return new class
{
    function get(VX $vx)
    {
        $menu = $vx->ui->createMenu();
        $menu->add("Testing", "/User/ae","el-icon-plus");
        $menu->add("Testing2", "/User/ae");
        $this->menu = $menu;
    }
};
