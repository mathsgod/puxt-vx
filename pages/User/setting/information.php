<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-05-12 
 */


return new class
{
    function get(VX $vx)
    {
        $schema = $vx->createSchema();

        $form = $schema->addForm()->showBack(false)->action($vx->user->uri());
        $form->header("Information");
        $form->value([
            "phone" => $vx->user->phone,
            "addr1" => $vx->user->addr1,
            "addr2" => $vx->user->addr2,
            "addr3" => $vx->user->addr3,
        ]);
        $form->addInput("Phone", "phone");
        $form->addInput("Address1", "addr1");
        $form->addInput("Address2", "addr2");
        $form->addInput("Address3", "addr3");

        return $schema;
    }
};
