{{menu|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-08-26 
 */
return new class
{
    function get(VX $vx)
    {
        $menu = $vx->ui->createMenu();
        $menu->add("Edit", "/User/1/ae");
        $this->menu = $menu;
        /*    $form = $vx->ui->createForm([]);
        $form->add("Name")->input("name")->required();
        $this->form = $form; */
    }
};
